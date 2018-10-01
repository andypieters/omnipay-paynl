<?php

namespace Omnipay\Paynl\Message\Request;


use Omnipay\Paynl\Message\Response\FetchTransactionResponse;

/**
 * Class FetchTransactionRequest
 * @package Omnipay\Paynl\Message\Request
 *
 * @method FetchTransactionResponse send()
 */
class FetchTransactionRequest extends AbstractPaynlRequest
{
    public function getData()
    {
        $this->validate('apiToken', 'tokenCode', 'transactionReference');

        return [
            'transactionId' => $this->getParameter('transactionReference')
        ];
    }

    public function sendData($data)
    {
        $responseData = $this->sendRequest('info', $data);
        $responseData['transaction']['transactionId'] = $data['transactionId'];
        return $this->response = new FetchTransactionResponse($this, $responseData);
    }
}