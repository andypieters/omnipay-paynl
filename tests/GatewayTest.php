<?php

namespace Omnipay\Paynl;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var \Omnipay\Paynl\Gateway
     */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testFetchIssuers()
    {
        $request = $this->gateway->fetchIssuers();

        $this->assertInstanceOf('Omnipay\Paynl\Message\FetchIssuersRequest', $request);
    }

    public function testFetchPaymentMethods()
    {
        $request = $this->gateway->fetchPaymentMethods();

        $this->assertInstanceOf('Omnipay\Paynl\Message\FetchPaymentMethodsRequest', $request);
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Paynl\Message\PurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testPurchaseReturn()
    {
        $request = $this->gateway->completePurchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\Paynl\Message\CompletePurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testFetchTransaction()
    {
        $request = $this->gateway->fetchTransaction(array(
            'apiKey' => 'key',
            'transactionReference' => 'tr_Qzin4iTWrU'
        ));

        $this->assertInstanceOf('Omnipay\Paynl\Message\FetchTransactionRequest', $request);

        $data = $request->getData();
        $this->assertSame('tr_Qzin4iTWrU', $data['id']);
    }
}
