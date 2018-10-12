<?php


namespace Omnipay\Paynl\Message\Response;


class VoidResponse extends AbstractPaynlResponse
{
    /**
     * @return null|string
     */
    public function getTransactionReference()
    {
        return $this->request->getTransactionReference();
    }
}