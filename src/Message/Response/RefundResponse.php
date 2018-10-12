<?php


namespace Omnipay\Paynl\Message\Response;


class RefundResponse extends AbstractPaynlResponse
{
    /**
     * @return string Description of the refund
     */
    public function getDescription()
    {
        return $this->data['description'];
    }

    /**
     * @return integer
     */
    public function getAmountInteger()
    {
        return (int)$this->data['amountRefunded'];
    }

    /**
     * @return null|string
     */
    public function getTransactionReference()
    {
        return $this->request->getTransactionReference();
    }
}