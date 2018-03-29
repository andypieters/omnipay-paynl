<?php

namespace Omnipay\Paynl;

use Omnipay\Common\AbstractGateway;

/**
 * Pay.nl Payment methods
 *
 * @link https://www.pay.nl
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Pay.nl';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'apitoken'  => '',
            'serviceId' => '',
        );
    }

    /**
     * @return string
     */
    public function getApitoken()
    {
        return $this->getParameter('apitoken');
    }

    /**
     * @param  string $value
     *
     * @return $this
     */
    public function setApitoken($value)
    {
        return $this->setParameter('apitoken', $value);
    }

    /**
     * @return string
     */
    public function getServiceId()
    {
        return $this->getParameter('serviceId');
    }

    /**
     * @param  string $value
     *
     * @return $this
     */
    public function setServiceId($value)
    {
        return $this->setParameter('serviceId', $value);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Paynl\Message\FetchIssuersRequest
     */
    public function fetchIssuers(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paynl\Message\FetchIssuersRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Paynl\Message\FetchPaymentMethodsRequest
     */
    public function fetchPaymentMethods(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paynl\Message\FetchPaymentMethodsRequest', $parameters);
    }

    /**
     * @param  array $parameters
     *
     * @return \Omnipay\Paynl\Message\FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paynl\Message\FetchTransactionRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Paynl\Message\PurchaseRequestTest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paynl\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Paynl\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paynl\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Paynl\Message\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paynl\Message\RefundRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Paynl\Message\CaptureRequest
     */
    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Paynl\Message\CaptureRequest', $parameters);
    }
}
