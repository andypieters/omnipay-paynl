<?php

namespace Omnipay\Paynl\Message;

/**
 * Send a Transaction Capture request
 *
 * @package Omnipay\Paynl\Message
 */
class CaptureRequest extends AbstractRequest {

    /**
     * Gather the data for
     *
     * @return array
     */
    public function getData()
    {
        $this->validate('apitoken', 'transactionReference');

        $data = array();
        $data['transactionId'] = $this->getTransactionReference();

        $amount = $this->getAmount();
        if (!empty($amount)) {
            $data['amount'] = round($amount * 100);
        }

        if ($items = $this->getItems()) {
            $data['products'] =  array_map(function($item) {
                $data = array(
                    'quantity' => $item->getQuantity(),
                );

                if (method_exists($item, 'getProductId')) {
                    $data['productId'] = $item->getProductId();
                } else {
                    $data['productId'] = substr($item->getName(), 0, 25);
                }

                return $data;
            }, $items->all());
        }

        return $data;
    }

    /**
     * Send the request
     *
     * @param mixed $data
     *
     * @return CaptureResponse
     */
    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', 'transaction/capture' , $data);

        return $this->response = new CaptureResponse($this, $httpResponse->json());
    }
}