<?php

namespace Omnipay\Paynl\Message;

/**
 * Paynl Fetch Transaction Request
 *
 * @method \Omnipay\Paynl\Message\FetchTransactionResponse send()
 */
class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('apitoken', 'transactionReference');

        $data                  = array();
        $data['transactionId'] = $this->getTransactionReference();

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse                               = $this->sendRequest('POST', 'transaction/info', $data);
        $resultData                                 = $httpResponse->json();
        $resultData['transaction']['transactionId'] = $data['transactionId'];

        return $this->response = new FetchTransactionResponse($this, $resultData);
    }
}
