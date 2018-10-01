<?php
/**
 * Created by PhpStorm.
 * User: andypieters
 * Date: 25/09/2018
 * Time: 17:14
 */

namespace Omnipay\Paynl\Message\Request;


use Omnipay\Common\Item;
use Omnipay\Paynl\Message\Response\PurchaseResponse;

/**
 * Class PurchaseRequest
 * @package Omnipay\Paynl\Message\Request
 *
 * @method PurchaseResponse send()
 */
class PurchaseRequest extends AbstractPaynlRequest
{
    /**
     * Regex to find streetname, housenumber and suffix out of a street string
     * @var string
     */
    private $addressRegex = '#^([a-z0-9 [:punct:]\']*) ([0-9]{1,5})([a-z0-9 \-/]{0,})$#i';

    public function getData()
    {
        $this->validate('tokenCode', 'apiToken', 'serviceId', 'amount', 'clientIp', 'returnUrl');

        // Mandatory fields
        $data = [
            'serviceId' => $this->getServiceId(),
            'amount' => $this->getAmountInteger(),
            'ipAddress' => $this->getClientIp(),
            'finishUrl' => $this->getReturnUrl(),
        ];

        $data['transaction'] = [];
        $data['transaction']['description'] = !empty($this->getDescription()) ? $this->getDescription() : null;
        $data['transaction']['currency'] = !empty($this->getCurrency()) ? $this->getCurrency() : 'EUR';
        $data['transaction']['orderExchangeUrl'] = !empty($this->getNotifyUrl()) ? $this->getNotifyUrl() : null;

        $data['testMode'] = $this->getTestMode() ? 1 : 0;
        $data['paymentOptionId'] = !empty($this->getPaymentMethod()) ? $this->getPaymentMethod() : null;
        $data['paymentOptionSubId'] = !empty($this->getIssuer()) ? $this->getIssuer() : null;

        if ($card = $this->getCard()) {
            $billingAddressParts = $this->getAddressParts($card->getBillingAddress1() . ' ' . $card->getBillingAddress2());
            $shippingAddressParts = ($card->getShippingAddress1() ? $this->getAddressParts($card->getShippingAddress1() . ' ' . $card->getShippingAddress2()) : $billingAddressParts);

            $data['enduser'] = [
                'initials' => $card->getFirstName(), //Pay has no support for firstName, but some methods require full name. Conversion to initials is handled by Pay.nl based on the payment method.
                'leasName' => $card->getLastName(),
                'gender' => $card->getGender(), //Should be inserted in the CreditCard as M/F
                'dob' => $card->getBirthday('d-m-Y'),
                'phoneNumber' => $card->getPhone(),
                'emailAddress' => $card->getEmail(),
                'language' => substr($card->getCountry(), 0, 2),
                'address' => array(
                    'streetName' => isset($shippingAddressParts[1]) ? $shippingAddressParts[1] : null,
                    'streetNumber' => isset($shippingAddressParts[2]) ? $shippingAddressParts[2] : null,
                    'streetNumberExtension' => isset($shippingAddressParts[3]) ? $shippingAddressParts[3] : null,
                    'zipCode' => $card->getShippingPostcode(),
                    'city' => $card->getShippingCity(),
                    'countryCode' => $card->getShippingCountry(),
                    'regionCode' => $card->getShippingState()
                ),
                'invoiceAddress' => array(
                    'initials' => $card->getBillingFirstName(),
                    'lastName' => $card->getBillingLastName(),
                    'streetName' => isset($billingAddressParts[1]) ? $billingAddressParts[1] : null,
                    'streetNumber' => isset($billingAddressParts[2]) ? $billingAddressParts[2] : null,
                    'streetNumberExtension' => isset($billingAddressParts[3]) ? $billingAddressParts[3] : null,
                    'zipCode' => $card->getBillingPostcode(),
                    'city' => $card->getBillingCity(),
                    'countryCode' => $card->getBillingCountry(),
                    'regionCode' => $card->getBillingState()
                )
            ];
        }
        if ($items = $this->getItems()) {
            $data['saleData'] = [
                'orderData' => array_map(function ($item) {
                    /** @var Item $item */
                    $data = [
                        'description' => $item->getDescription(),
                        'price' => round($item->getPrice() * 100),
                        'quantity' => $item->getQuantity(),
                        'vatCode' => 0,
                    ];
                    if (method_exists($item, 'getProductId')) {
                        $data['productId'] = $item->getProductId();
                    } else {
                        $data['productId'] = substr($item->getName(), 0, 25);
                    }
                    if (method_exists($item, 'getProductType')) {
                        $data['productType'] = $item->getProductType();
                    }
                    if (method_exists($item, 'getVatPercentage')) {
                        $data['vatPercentage'] = $item->getVatPercentage();
                    }
                    return $data;
                }, $items->all()),
            ];
        }


        return $data;
    }

    public function sendData($data)
    {
        $responseData = $this->sendRequest('start', $data);

        return $this->response = new PurchaseResponse($this, $responseData);
    }

    /**
     * Get the parts of an address
     * @param string $address
     * @return array
     */
    public function getAddressParts($address)
    {
        $addressParts = [];
        preg_match($this->addressRegex, trim($address), $addressParts);
        return array_filter($addressParts, 'trim');
    }
}