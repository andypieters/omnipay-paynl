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
    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('apiToken', 'tokenCode', 'transactionReference');

        return [
            'transactionId' => $this->getParameter('transactionReference')
        ];
    }

    /**
     * @param array $data
     * @return \Omnipay\Common\Message\ResponseInterface|FetchTransactionResponse
     */
    public function sendData($data)
    {
        $responseData = $this->sendRequest('info', $data);
        return $this->response = new FetchTransactionResponse($this, $responseData);
    }
}