<?php

namespace Omnipay\Paynl\Message\Response;


class PurchaseResponse extends AbstractPaynlResponse
{
    /**
     * When you do a `purchase` the request is never successful because
     * you need to redirect off-site to complete the purchase.
     *
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function isRedirect()
    {
        return isset($this->data['transaction']['paymentURL']);
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectUrl()
    {
        return isset($this->data['transaction']['paymentURL']) ? $this->data['transaction']['paymentURL'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectData()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getTransactionReference()
    {
        return isset($this->data['transaction']['transactionId']) ? $this->data['transaction']['transactionId'] : null;
    }

    /**
     * @return string|null The payment accept code used to identify bank transfers
     */
    public function getAcceptCode()
    {
        return isset($this->data['transaction']['paymentReference']) ? $this->data['transaction']['paymentReference'] : null;
    }

}