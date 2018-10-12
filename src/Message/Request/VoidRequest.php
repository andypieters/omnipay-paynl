<?php


namespace Omnipay\Paynl\Message\Request;


use Omnipay\Paynl\Message\Response\VoidResponse;

/**
 * Class VoidRequest
 * @package Omnipay\Paynl\Message\Request
 *
 * @method VoidResponse send()
 */
class VoidRequest extends AbstractPaynlRequest
{
    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('tokenCode', 'apiToken', 'transactionReference');

        $data['transactionId'] = $this->getTransactionReference();

        return $data;
    }

    /**
     * @param array $data
     * @return \Omnipay\Common\Message\ResponseInterface|VoidResponse
     */
    public function sendData($data)
    {
        $responseData = $this->sendRequest('voidAuthorization', $data);
        return $this->response = new VoidResponse($this, $responseData);
    }
}