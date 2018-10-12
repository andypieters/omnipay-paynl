<?php


namespace Omnipay\Paynl\Message\Response;

/**
 * Class CaptureResponse
 * @package Omnipay\Paynl\Message\Response
 *

 */
class CaptureResponse extends AbstractPaynlResponse
{
    /**
     * @return null|string
     */
    public function getTransactionReference()
    {
        return $this->request->getTransactionReference();
    }
}