<?php

namespace Omnipay\Mollie\Message;

/**
 * Mollie Fetch Transaction Request
 *
 * @method \Omnipay\Mollie\Message\FetchTransactionResponse send()
 */
class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('apitoken', 'serviceId' ,'transactionReference');

        $data = array();
        $data['transactionId'] = $this->getTransactionReference();

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', 'transaction/info' , $data);

        return $this->response = new FetchTransactionResponse($this, $httpResponse->json());
    }
}
