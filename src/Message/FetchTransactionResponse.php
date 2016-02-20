<?php

namespace Omnipay\Paynl\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

class FetchTransactionResponse extends AbstractResponse implements RedirectResponseInterface
{
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
        if ($this->isRedirect()) {
            return $this->data['transaction']['paymentURL'];
        }
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
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return parent::isSuccessful();
    }

    /**
     * @return boolean
     */
    public function isOpen()
    {
        return isset($this->data['paymentDetails']['stateName']) && 'PENDING' === $this->data['paymentDetails']['stateName'];
    }

    /**
     * @return boolean
     */
    public function isCancelled()
    {
        return isset($this->data['paymentDetails']['stateName']) && 'CANCEL' === $this->data['paymentDetails']['stateName'];
    }

    /**
     * @return boolean
     */
    public function isPaid()
    {
        return isset($this->data['paymentDetails']['stateName']) && 'PAID' === $this->data['paymentDetails']['stateName'];
    }

    /**
     * @return boolean
     */
//    public function isPaidOut()
//    {
//        return isset($this->data['status']) && 'paidout' === $this->data['status'];
//    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return isset($this->data['paymentDetails']['stateName']) && 'EXPIRED' === $this->data['paymentDetails']['stateName'];
    }

    /**
     * @return mixed
     */
    public function getTransactionReference()
    {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        if (isset($this->data['paymentDetails']['stateName'])) {
            return $this->data['paymentDetails']['stateName'];
        }
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        if (isset($this->data['paymentDetails']['paidAmount'])) {
            return $this->data['paymentDetails']['paidAmount'] / 100;
        }
    }
}
