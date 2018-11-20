<?php

namespace Omnipay\Paynl\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{

    protected $endpoint = 'https://rest-api.pay.nl/v8/';

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
     * @param  string $value
     *
     * @return $this
     */
    public function setServiceId($value)
    {
        return $this->setParameter('serviceId', $value);
    }

    /**
     * @param  string $value
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    protected function sendRequest($method, $endpoint, array $data = array())
    {
        $data['token']     = $this->getApitoken();
        $data['serviceId'] = $this->getServiceId();

        $httpRequest = $this->httpClient->createRequest(
            $method, $this->endpoint . $endpoint . '/json', array(), $data
        );

        return $httpRequest->send();
    }

    /**
     * @return string
     */
    public function getApitoken()
    {
        return $this->getParameter('apitoken');
    }

    /**
     * @return string
     */
    public function getServiceId()
    {
        return $this->getParameter('serviceId');
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

}
