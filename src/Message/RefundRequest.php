<?php

namespace Omnipay\Paynl\Message;

use Omnipay\Common\Message\ResponseInterface;

/**
 * Class RefundRequest
 *
 * Send a transaction/refund request to Pay.nl
 *
 * @package Omnipay\Paynl\Message
 */
class RefundRequest extends AbstractRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('apitoken', 'serviceId', 'transactionReference');

        $data = array();
        $data['transactionId'] = $this->getTransactionReference();

        if ($this->getAmount() != null) {
            $data['amount'] = round($this->getAmount() * 100);
        }

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param array $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', 'transaction/refund', $data);

        return $this->response = new RefundResponse($this, $httpResponse->json());
    }
}