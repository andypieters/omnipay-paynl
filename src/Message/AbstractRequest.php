<?php

namespace Omnipay\Paynl\Message;

use Guzzle\Common\Event;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest {

    protected $endpoint = 'https://rest-api.pay.nl/v5/';

    /**
     * @return string
     */
    public function getApitoken() {
        return $this->getParameter('apitoken');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setApitoken($value) {
        return $this->setParameter('apitoken', $value);
    }

    /**
     * @return string
     */
    public function getServiceId() {
        return $this->getParameter('serviceId');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setServiceId($value) {
        return $this->setParameter('serviceId', $value);
    }

    protected function sendRequest($method, $endpoint, array $data = array()) {
        $this->httpClient->getEventDispatcher()->addListener('request.error', function (Event $event) {
            /**
             * @var \Guzzle\Http\Message\Response $response
             */
            $response = $event['response'];

            if ($response->isError()) {
                $event->stopPropagation();
            }
        });
        
        $data['token'] = $this->getApitoken();
        $data['serviceId'] = $this->getServiceId();
        
        $httpRequest = $this->httpClient->createRequest(
                $method, $this->endpoint . $endpoint.'/json', array(), $data
        );

        return $httpRequest->send();
    }

}
