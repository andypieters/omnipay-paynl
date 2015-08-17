<?php

namespace Omnipay\Paynl\Message;

class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function isSuccessful()
    {
        return !$this->isRedirect() && isset($this->data['request']['result']) && $this->data['request']['result'] == 1;
    }

    public function getMessage()
    {
        if (isset($this->data['request']['errorMessage'])) {
            return $this->data['request']['errorMessage'];
        }
    }
}
