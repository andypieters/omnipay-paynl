<?php
/**
 * Created by PhpStorm.
 * User: andypieters
 * Date: 30-08-18
 * Time: 00:56
 */

namespace Omnipay\Paynl\Message\Response;


use Omnipay\Common\Message\AbstractResponse;

abstract class AbstractPaynlResponse extends AbstractResponse
{
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
        return isset($this->data['request']['errorMessage']) && !empty($this->data['request']['errorMessage'])? $this->data['request']['errorMessage']: null;
    }

}