<?php

namespace Omnipay\Paynl\Message;

/**
 * Paynl Fetch PaymentMethods Request
 *
 * @method \Omnipay\Paynl\Message\FetchPaymentMethodsResponse send()
 */
class FetchPaymentMethodsRequest extends AbstractRequest
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
        $httpResponse = $this->sendRequest('POST', 'transaction/getServicePaymentOptions');

        return $this->response = new FetchPaymentMethodsResponse($this, $httpResponse->json());
    }
}
