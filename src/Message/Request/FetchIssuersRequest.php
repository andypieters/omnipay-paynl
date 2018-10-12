<?php

namespace Omnipay\Paynl\Message\Request;

use Omnipay\Paynl\Message\Response\FetchIssuersResponse;

/**
 * Class FetchIssuersRequest
 * @package Omnipay\Paynl\Message\Request
 *
 * @method FetchIssuersResponse send()
 */
class FetchIssuersRequest extends AbstractPaynlRequest
{
    public function getData()
    {
        return [];
    }

    public function sendData($data)
    {
        $responseData = $this->sendRequest('getBanks');

        return $this->response = new FetchIssuersResponse($this, $responseData);
    }
}