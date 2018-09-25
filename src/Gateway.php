<?php

namespace Omnipay\Paynl;

use Omnipay\Common\AbstractGateway;
use Omnipay\Paynl\Message\Request\FetchTransactionRequest;

class Gateway extends AbstractGateway
{

    public function getName()
    {
        return 'Paynl';
    }

    public function getDefaultParameters()
    {
        return [
            'tokenCode' => '',
            'apiToken' => '',
            'serviceId' => ''
        ];
    }

    public function setTokenCode($value)
    {
        $this->setParameter('tokenCode', $value);
        return $this;
    }

    public function getTokenCode()
    {
        return $this->getParameter('tokenCode');
    }

    public function setApiToken($value)
    {
        $this->setParameter('apiToken', $value);
        return $this;
    }

    public function getApiToken()
    {
        return $this->getParameter('apiToken');
    }

    public function setServiceId($value)
    {
        $this->setParameter('serviceId', $value);
        return $this;
    }

    public function getServiceId()
    {
        return $this->getParameter('serviceId');
    }

    public function fetchTransaction(array $parameters = []){
        $request = $this->createRequest(FetchTransactionRequest::class, $parameters);

        return $request;
    }


}