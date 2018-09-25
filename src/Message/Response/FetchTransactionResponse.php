<?php

namespace Omnipay\Paynl\Message\Response;


class FetchTransactionResponse extends AbstractPaynlResponse
{
    /**
     * @return bool
     */
    public function isCancelled()
    {
        return isset($this->data['paymentDetails']['stateName']) && 'CANCEL' === $this->data['paymentDetails']['stateName'];
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return
            isset($this->data['paymentDetails']['stateName']) &&
            (strpos('PENDING', strtoupper($this->data['paymentDetails']['stateName'])) !== false ||
                $this->data['paymentDetails']['stateName'] == 'VERIFY');
    }

    /**
     * @return bool
     */
    public function isOpen()
    {
        return
            isset($this->data['paymentDetails']['stateName']) &&
            strpos('PENDING', strtoupper($this->data['paymentDetails']['stateName'])) !== false;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return isset($this->data['paymentDetails']['stateName']) && 'EXPIRED' === $this->data['paymentDetails']['stateName'];
    }

    /**
     * @return null|string
     */
    public function getTransactionReference()
    {
        return isset($this->data['transaction']['transactionId']) ? $this->data['transaction']['transactionId'] : null;
    }

    /**
     * @return null
     */
    public function getStatus()
    {
        return isset($this->data['paymentDetails']['stateName']) ? $this->data['paymentDetails']['stateName'] : null;
    }

    /**
     * @return float|null
     */
    public function getAmount()
    {
        return isset($this->data['paymentDetails']['paidCurrenyAmount']) ? $this->data['paymentDetails']['paidCurrenyAmount'] / 100 : null;
    }

    /**
     * @return string|null The paid currency
     */
    public function getCurrency()
    {
        return isset($this->data['paymentDetails']['paidCurrency']) ? $this->data['paymentDetails']['paidCurrency'] : null;
    }

    /**
     * @return boolean
     */
    public function isPaid()
    {
        return isset($this->data['paymentDetails']['stateName']) && in_array($this->data['paymentDetails']['stateName'],
                array('PAID', 'AUTHORIZE'));
    }

    /**
     * @return boolean
     */
    public function isAuthorized()
    {
        return isset($this->data['paymentDetails']['stateName']) && $this->data['paymentDetails']['stateName'] == 'AUTHORIZE';
    }
}