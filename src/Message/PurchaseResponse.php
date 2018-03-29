<?php

namespace Omnipay\Paynl\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
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
        return isset($this->data['transaction']['paymentURL'])?$this->data['transaction']['paymentURL']:null;
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

}
