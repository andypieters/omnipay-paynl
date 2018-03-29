<?php

namespace Omnipay\Paynl\Message;

class RefundResponse extends AbstractResponse
{
    /**
     * Get the refundId, if provided
     *
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (!empty($this->data['refundId'])) {
            return $this->data['refundId'];
        }

        return null;
    }
}