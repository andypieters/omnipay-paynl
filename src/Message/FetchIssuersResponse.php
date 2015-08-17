<?php

namespace Omnipay\Paynl\Message;

use Omnipay\Common\Issuer;
use Omnipay\Common\Message\FetchIssuersResponseInterface;

class FetchIssuersResponse extends AbstractResponse implements FetchIssuersResponseInterface
{
    /**
     * Return available issuers as an associative array.
     *
     * @return \Omnipay\Common\Issuer[]
     */
    public function getIssuers()
    {
        if (isset($this->data['countryOptionList']['NL']['paymentOptionList'][10])) {
            $issuers = array();
            
            foreach ($this->data['countryOptionList']['NL']['paymentOptionList'][10] as $issuer) {
                $issuers[] = new Issuer($issuer['id'], $issuer['visibleName'], 10);
            }

            return $issuers;
        }
    }
}
