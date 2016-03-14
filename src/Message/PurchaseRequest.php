<?php

namespace Omnipay\Paynl\Message;

/**
 * Paynl Purchase Request
 *
 * @method \Omnipay\Paynl\Message\PurchaseResponse send()
 */
class PurchaseRequest extends AbstractRequest {

    private $addressRegex = '/^(\D+)([0-9]+).*$/';
   
    
    public function getData() {
        $this->validate('apitoken', 'serviceId', 'amount', 'description', 'returnUrl');

        $data = array();
        
        
        
        $data['amount'] = round($this->getAmount() * 100);
        $data['description'] = $this->getDescription();
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

            $initials = implode('.', array_map($firstLetterInWord, explode(' ', trim($card->getFirstName())))) . '.';
            $invoiceInitials = implode('.', array_map($firstLetterInWord, explode(' ', trim($card->getBillingFirstName())))) . '.';

            $addressParts = $invoiceAddressParts = [];
            preg_match($this->addressRegex, $card->getAddress1(), $addressParts);
            preg_match($this->addressRegex, $card->getBillingAddress1(), $invoiceAddressParts);

            $data['enduser'] = array(
                'initials' => $initials,
                'lastName' => $card->getLastName(),
                'gender' => $card->getGender(), // could be problematic, there is no specification as to how a gender is passed to credit card objects
                'dob' => $card->getBirthday('d-m-Y'),
                'phoneNumber' => $card->getPhone(),
                'emailAddress' => $card->getEmail(),
                'address' => array(
                    'streetName' => trim($addressParts[1]),
                    'streetNumber' => $addressParts[2],
                    'zipCode' => $card->getPostcode(),
                    'city' => $card->getCity(),
                    'countryCode' => $card->getCountry(),
                ),
                'invoiceAddress' => array(
                    'initials' => $invoiceInitials,
                    'lastName' => $card->getBillingLastName(),
                    'streetName' => trim($invoiceAddressParts[1]),
                    'streetNumber' => $invoiceAddressParts[2],
                    'zipCode' => $card->getBillingPostcode(),
                    'countryCode' => $card->getBillingCountry()
                )
            );
        }

        $data['testMode'] = $this->getTestMode() ? 1 : 0;

        return $data;
    }

    public function sendData($data) {
        $httpResponse = $this->sendRequest('POST', 'transaction/start', $data);

        return $this->response = new PurchaseResponse($this, $httpResponse->json());
    }

}
