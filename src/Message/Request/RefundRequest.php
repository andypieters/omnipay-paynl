<?php


namespace Omnipay\Paynl\Message\Request;


use Omnipay\Paynl\Message\Response\RefundResponse;

/**
 * Class RefundRequest
 * @package Omnipay\Paynl\Message\Request
 *
 * @method RefundResponse send()
 */
class RefundRequest extends AbstractPaynlRequest
{
    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('tokenCode', 'apiToken', 'transactionReference');

        $data = [
            'transactionId' => $this->getTransactionReference() ?: null,
            'description' => $this->getDescription() ?: null,
            'amount' => $this->getAmountInteger() ?: null
        ];

        return $data;
    }

    /**
     * @param array $data
     * @return \Omnipay\Common\Message\ResponseInterface|RefundResponse
     */
    public function sendData($data)
    {
        $responseData = $this->sendRequest('refund', $data);
        return $this->response = new RefundResponse($this, $responseData);
    }
}