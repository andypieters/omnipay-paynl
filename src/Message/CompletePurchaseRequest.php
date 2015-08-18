<?php

namespace Omnipay\Paynl\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Paynl Complete Purchase Request
 *
 * @method \Omnipay\Paynl\Message\CompletePurchaseResponse send()
 */
class CompletePurchaseRequest extends FetchTransactionRequest
{
    public function getData()
    {
        $this->validate('apitoken');

        $data = array();
        $data['transactionId'] = $this->getTransactionReference();

        
        if (empty($data['transactionId'])) {
            $data['transactionId'] = $_GET['orderId'];
        }
        if (empty($data['transactionId'])) {
            $data['transactionId'] = $_GET['order_id'];
        }
        

        if (empty($data['transactionId'])) {
            throw new InvalidRequestException("The transactionReference parameter is required");
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', 'transaction/info' , $data);

        return $this->response = new CompletePurchaseResponse($this, $httpResponse->json());
    }
}
