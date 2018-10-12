<?php

namespace Omnipay\Paynl;

use Omnipay\Common\AbstractGateway;
use Omnipay\Paynl\Message\Request\CaptureRequest;
use Omnipay\Paynl\Message\Request\CompletePurchaseRequest;
use Omnipay\Paynl\Message\Request\FetchIssuersRequest;
use Omnipay\Paynl\Message\Request\FetchPaymentMethodsRequest;
use Omnipay\Paynl\Message\Request\FetchTransactionRequest;
use Omnipay\Paynl\Message\Request\PurchaseRequest;
use Omnipay\Paynl\Message\Request\RefundRequest;
use Omnipay\Paynl\Message\Request\VoidRequest;

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
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|FetchTransactionRequest
     */
    public function fetchTransaction(array $options = [])
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|FetchPaymentMethodsRequest
     */
    public function fetchPaymentMethods(array $options = [])
    {
        return $this->createRequest(FetchPaymentMethodsRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|FetchIssuersRequest
     */
    public function fetchIssuers(array $options = [])
    {
        return $this->createRequest(FetchIssuersRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|PurchaseRequest
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|VoidRequest
     */
    public function void(array $options = array())
    {
        return $this->createRequest(VoidRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|CaptureRequest
     */
    public function capture(array $options = array())
    {
        return $this->createRequest(CaptureRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|RefundRequest
     */
    public function refund(array $options = array())
    {
        return $this->createRequest(RefundRequest::class, $options);
    }

    /**
     * @param array $options
     * @return \Omnipay\Common\Message\AbstractRequest|CompletePurchaseRequest
     */
    public function completePurchase(array $options = array())
    {
        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }
}