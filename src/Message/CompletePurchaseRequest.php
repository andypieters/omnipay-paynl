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
        $data['id'] = $this->getTransactionReference();

        if (!isset($data['id'])) {
            $data['id'] = $this->httpRequest->request->get('id');
        }

        if (empty($data['id'])) {
            throw new InvalidRequestException("The transactionReference parameter is required");
        }

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('GET', '/payments/' . $data['id']);

        return $this->response = new CompletePurchaseResponse($this, $httpResponse->json());
    }
}
