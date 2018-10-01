<?php

namespace Omnipay\Paynl\Message\Response;


use Omnipay\Common\Issuer;

class FetchIssuersResponse extends AbstractPaynlResponse
{
    /**
     * @inheritdoc
     */
    public function isSuccessful()
    {
        return isset($this->data) && is_array($this->data) && !empty($this->data);
    }

    /**
     * @return Issuer[]|null
     */
    public function getIssuers()
    {
        $issuers = [];
        if (empty($this->data) || !is_array($this->data)) return null;

        foreach ($this->data as $issuer) {
            $issuers[] = new Issuer($issuer['id'], $issuer['name'], '10');
        }
        return $issuers;
    }
}