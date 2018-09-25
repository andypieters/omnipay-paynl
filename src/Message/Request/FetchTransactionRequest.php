<?php
/**
 * Created by PhpStorm.
 * User: andypieters
 * Date: 30-08-18
 * Time: 00:49
 */

namespace Omnipay\Paynl\Message\Request;


use Omnipay\Paynl\Message\Response\FetchTransactionResponse;

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