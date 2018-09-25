<?php

namespace Omnipay\Paynl;

use Omnipay\Common\AbstractGateway;
use Omnipay\Paynl\Message\Request\FetchPaymentMethodsRequest;
use Omnipay\Paynl\Message\Request\FetchTransactionRequest;

class Gateway extends AbstractGateway
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Paynl';
    }

    /**
     * @@inheritdoc
     */
    public function getDefaultParameters()
    {
        return [
            'tokenCode' => '',
            'apiToken' => '',
            'serviceId' => ''
        ];
    }

    /**
     * @param string $value Example: AT-1234-5678
     * @return $this
     */
    public function setTokenCode($value)
    {
        $this->setParameter('tokenCode', $value);
        return $this;
    }

    /**
     * @return string
     */
    public function getTokenCode()
    {
        return $this->getParameter('tokenCode');
    }

    /**
     * @param string $value Your API token
     * @return $this
     */
    public function setApiToken($value)
    {
        $this->setParameter('apiToken', $value);
        return $this;
    }

    /**
     * @return string
     */
    public function getApiToken()
    {
        return $this->getParameter('apiToken');
    }

    /**
     * @param string $value Example: SL-1234-5678
     * @return $this
     */
    public function setServiceId($value)
    {
        $this->setParameter('serviceId', $value);
        return $this;
    }

    /**
     * @return string
     */
    public function getServiceId()
    {
        return $this->getParameter('serviceId');
    }

    /**
     * @param array $parameters
     * @return FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = [])
    {
        return $this->createRequest(FetchTransactionRequest::class, $parameters);
    }

    /**
     * @return FetchPaymentMethodsRequest
     */
    public function fetchPaymentMethods()
    {
        return $this->createRequest(FetchPaymentMethodsRequest::class, []);
    }

}