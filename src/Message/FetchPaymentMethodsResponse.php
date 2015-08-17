<?php

namespace Omnipay\Paynl\Message;

use Omnipay\Common\Message\FetchPaymentMethodsResponseInterface;
use Omnipay\Common\PaymentMethod;

class FetchPaymentMethodsResponse extends AbstractResponse implements FetchPaymentMethodsResponseInterface
{
    /**
     * Return available paymentmethods as an associative array.
     *
     * @return \Omnipay\Common\PaymentMethod[]
     */
    public function getPaymentMethods()
    {
        if (isset($this->data['paymentProfiles'])) {
            $paymentMethods = array();
            foreach ($this->data['paymentProfiles'] as $method) {
                $paymentMethods[] = new PaymentMethod($method['id'], $method['visibleName']);
            }

            return $paymentMethods;
        }
    }
}
