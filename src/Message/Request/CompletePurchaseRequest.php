<?php


namespace Omnipay\Paynl\Message\Request;


use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Paynl\Message\Response\CompletePurchaseResponse;

/**
 * Class CompletePurchaseRequest
 * @package Omnipay\Paynl\Message\Request
 *
 * @method CompletePurchaseResponse send()
 */
class CompletePurchaseRequest extends AbstractPaynlRequest
{
    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('tokenCode', 'apiToken');

        $data = [
            'transactionId' => $this->getTransactionReference()
        ];

        if (empty($data['transactionId'])) {
            $data['transactionId'] = isset($_GET['orderId']) ? $_GET['orderId'] : null;
        }
        if (empty($data['transactionId'])) {
            $data['transactionId'] = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : null;
        }

        if (empty($data['transactionId'])) {
            throw new InvalidRequestException("The transactionReference parameter is required");
        }

        return $data;
    }

    /**
     * @param mixed $data
     * @return \Omnipay\Common\Message\ResponseInterface|CompletePurchaseResponse
     */
    public function sendData($data)
    {
        $responseData = $this->sendRequest('info', $data);
        return new CompletePurchaseResponse($this, $responseData);
    }
}