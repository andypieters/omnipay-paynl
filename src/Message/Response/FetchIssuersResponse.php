<?php
/**
 * Created by PhpStorm.
 * User: andypieters
 * Date: 25/09/2018
 * Time: 15:42
 */

namespace Omnipay\Paynl\Message\Response;


use Omnipay\Common\Issuer;

class FetchIssuersResponse extends AbstractPaynlResponse
{
    /**
     * @inheritdoc
     */
    public function isSuccessful()
    {
        return isset($this->data) && is_array($this->data);
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