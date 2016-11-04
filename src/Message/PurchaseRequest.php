<?php

namespace Omnipay\Paynl\Message;

/**
 * Paynl Purchase Request
 *
 * @method \Omnipay\Paynl\Message\PurchaseResponse send()
 */
class PurchaseRequest extends AbstractRequest {

    /**
     * Regex to find streetname, housenumber and suffix out of a street string
     * @var string
     */
    private $addressRegex = '#^([a-z0-9 [:punct:]\']*) ([0-9]{1,5})([a-z0-9 \-/]{0,})$#i';

    /**
     * Return the data formatted for PAY.nl
     * @return array
     */
    public function getData() {
        $this->validate('apitoken', 'serviceId', 'amount', 'description', 'returnUrl');

        $data['amount'] = round($this->getAmount() * 100);
        $data['transaction']['description'] = $this->getDescription();
        $data['finishUrl'] = $this->getReturnUrl();
        $data['ipAddress'] = $this->getClientIp();
        if ($this->getPaymentMethod()) {
            $data['paymentOptionId'] = $this->getPaymentMethod();
        }
        if ($this->getPaymentMethod()) {
            $data['paymentOptionId'] = $this->getPaymentMethod();
            if ($this->getPaymentMethod() == 10 && $this->getIssuer()) {
                $data['paymentOptionSubId'] = $this->getIssuer();
            }
        }

        if ($this->getNotifyUrl()) {
            $data['transaction']['orderExchangeUrl'] = $this->getNotifyUrl();
        }

        if ($card = $this->getCard()) {
            $firstLetterInWord = function($word) {
                return strtoupper(substr($word, 0, 1));
            };

            $initials = implode('.', array_map($firstLetterInWord, explode(' ', trim($card->getFirstName()))));
            $invoiceInitials = implode('.', array_map($firstLetterInWord, explode(' ', trim($card->getBillingFirstName()))));

            $addressParts = [];
            preg_match($this->addressRegex, $card->getBillingAddress1(), $addressParts);
            $addressParts = array_filter($addressParts, 'trim');

            $data['enduser'] = array(
                'initials' => $initials ? $initials.'.' : '',
                'lastName' => $card->getLastName(),
                'gender' => $card->getGender(), // could be problematic, there is no specification as to how a gender is passed to credit card objects
                'dob' => $card->getBirthday('d-m-Y'),
                'phoneNumber' => $card->getPhone(),
                'emailAddress' => $card->getEmail(),
                'address' => array(
                    'streetName' => $addressParts[1],
                    'streetNumber' => isset($addressParts[2]) ? $addressParts[2] : null,
                    'streetNumberExtension' => isset($addressParts[3]) ? $addressParts[3] : null,
                    'zipCode' => $card->getPostcode(),
                    'city' => $card->getCity(),
                    'countryCode' => $card->getCountry(),
                ),
                'invoiceAddress' => array(
                    'initials' => $invoiceInitials ? $invoiceInitials.'.' : '',
                    'lastName' => $card->getBillingLastName(),
                    'streetName' => $addressParts[1],
                    'streetNumber' => isset($addressParts[2]) ? $addressParts[2] : null,
                    'streetNumberExtension' => isset($addressParts[3]) ? $addressParts[3] : null,
                    'zipCode' => $card->getBillingPostcode(),
                    'countryCode' => $card->getBillingCountry()
                )
            );
        }

        if ($items = $this->getItems()) {
            $data['saleData'] = array(
                'orderData' => array_map(function($item) {
                    $data = array(
                        'description' => $item->getDescription(),
                        'price' => ($item->getPrice() * 100), //convert the price from a double into a string
                        'quantity' => $item->getQuantity(),
                        'vatCode' => 0,
                    );

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
            );
        }

        $data['testMode'] = $this->getTestMode() ? 1 : 0;
        return $data;
    }

    /**
     * Send the data
     * @param array $data
     * @return AbstractResponse
     */
    public function sendData($data) {
        $httpResponse = $this->sendRequest('POST', 'transaction/start', $data);
        return $this->response = new PurchaseResponse($this, $httpResponse->json());
    }
}
