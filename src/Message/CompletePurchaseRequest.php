<?php

namespace Omnipay\Paynl\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Paynl Complete Purchase Request
 *
 */
class CompletePurchaseRequest extends FetchTransactionRequest
{
    public function getData()
    {
        $this->validate('apitoken');

        $data                  = array();
        $data['transactionId'] = $this->getTransactionReference();


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

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', 'transaction/info', $data);

        return $this->response = new CompletePurchaseResponse($this, $httpResponse->json());
    }
}
