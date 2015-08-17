<?php

namespace Omnipay\Paynl\Message;

/**
 * Paynl Fetch Issuers Request
 *
 * @method \Omnipay\Paynl\Message\FetchIssuersResponse send()
 */
class FetchIssuersRequest extends AbstractRequest
{
    /**
     * @return null
     */
    public function getData()
    {
        $this->validate('apitoken', 'serviceId');
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', 'Transaction/getServicePaymentOptions');

        return $this->response = new FetchIssuersResponse($this, $httpResponse->json());
    }
}
