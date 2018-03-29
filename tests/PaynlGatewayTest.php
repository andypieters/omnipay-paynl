<?php

namespace Omnipay\Paynl;

use Omnipay\Tests\GatewayTestCase;

class PaynlGatewayTest extends GatewayTestCase
{

    /**
     * @var Gateway
     */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testApiToken()
    {
        $token = 'your-api-token-here';
        $this->gateway->setApitoken($token);

        $this->assertEquals($token, $this->gateway->getApitoken());
    }

    public function testServiceId()
    {
        $serviceId = 'SL-0123-4567';
        $this->gateway->setServiceId($serviceId);
        $this->assertEquals($serviceId, $this->gateway->getServiceId());
    }

    public function testFetchIssuers()
    {
        $request = $this->gateway->fetchIssuers();
        $this->assertInstanceOf('Omnipay\Paynl\Message\FetchIssuersRequest', $request);
        $this->assertNull($request->getData());
    }

    public function testFetchPaymentMethods()
    {
        $request = $this->gateway->fetchPaymentMethods();
        $this->assertInstanceOf('Omnipay\Paynl\Message\FetchPaymentMethodsRequest', $request);
        $this->assertNull($request->getData());
    }

    public function testFetchTransaction()
    {
        $transactionId = '012345678xabc';
        $request       = $this->gateway->fetchTransaction(array('transactionReference' => $transactionId));
        $this->assertInstanceOf('Omnipay\Paynl\Message\FetchTransactionRequest', $request);
        $this->assertEquals(array('transactionId' => $transactionId), $request->getData());
    }
}