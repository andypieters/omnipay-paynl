<?php

namespace Omnipay\Paynl\Message\Response;


use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Paynl\Message\Request\AbstractPaynlRequest;

abstract class AbstractPaynlResponse extends AbstractResponse
{
    /**
     * @var AbstractPaynlRequest
     */
    protected $request;

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data['request']['result']) && $this->data['request']['result'] == 1;
    }

    /**
     * @return null|string The error message
     */
    public function getMessage()
    {
        return isset($this->data['request']['errorMessage']) && !empty($this->data['request']['errorMessage']) ? $this->data['request']['errorMessage'] : null;
    }

}