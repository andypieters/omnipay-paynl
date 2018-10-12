<?php


namespace Omnipay\Paynl\Message\Request;


use Omnipay\Common\Item;
use Omnipay\Paynl\Message\Response\CaptureResponse;

/**
 * Class CaptureRequest
 * @package Omnipay\Paynl\Message\Request
 *
 * @method CaptureResponse send()
 */
class CaptureRequest extends AbstractPaynlRequest
{

    /**
     * @param string $trackTrace
     * @return CaptureRequest
     */
    public function setTrackTrace($trackTrace)
    {
        return $this->setParameter('trackTrace', $trackTrace);
    }

    /**
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('tokenCode', 'apiToken', 'transactionReference');


        $data = [
            'transactionId' => $this->getTransactionReference()
        ];

        if ($items = $this->getItems()) {
            $data['products'] = array_map(function ($item) {
                /** @var Item|\Omnipay\Paynl\Common\Item $item */
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

        if ($this->getTrackTrace()) {
            $data['tracktrace'] = $this->getTrackTrace();
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getTrackTrace()
    {
        return $this->getParameter('trackTrace');
    }

    /**
     * @param array $data
     * @return \Omnipay\Common\Message\ResponseInterface|CaptureResponse
     */
    public function sendData($data)
    {
        $responseData = $this->sendRequest('capture', $data);
        return $this->response = new CaptureResponse($this, $responseData);
    }
}