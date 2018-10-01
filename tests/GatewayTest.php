<?php

namespace Omnipay\Paynl\Test;

use Omnipay\Paynl\Gateway;
use Omnipay\Paynl\Message\Request\FetchIssuersRequest;
use Omnipay\Paynl\Message\Request\FetchPaymentMethodsRequest;
use Omnipay\Paynl\Message\Request\FetchTransactionRequest;
use Omnipay\Paynl\Message\Request\PurchaseRequest;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway();
    }

    public function testFetchIssuers()
    {
        $request = $this->gateway->fetchIssuers();
        $this->assertInstanceOf(FetchIssuersRequest::class, $request);
    }

    public function testFetchPaymentMethods()
    {
        $request = $this->gateway->fetchPaymentMethods();
        $this->assertInstanceOf(FetchPaymentMethodsRequest::class, $request);
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction();
        $this->assertInstanceOf(FetchTransactionRequest::class, $request);
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase();
        $this->assertInstanceOf(PurchaseRequest::class, $request);
    }
}
