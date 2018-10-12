<?php

namespace Omnipay\Paynl\Test\Message;


use Omnipay\Paynl\Message\Request\CompletePurchaseRequest;
use Omnipay\Paynl\Message\Response\CompletePurchaseResponse;
use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    /**
     * @var CompletePurchaseRequest
     */
    protected $request;

    public function testSendSuccessVerify()
    {
        $this->setMockHttpResponse('FetchTransactionSuccess-Verify.txt');

        $transactionReference = uniqid();
        $this->request->setTransactionReference($transactionReference);

        $this->assertEquals($transactionReference, $this->request->getTransactionReference());

        $response = $this->request->send();

        $this->assertInstanceOf(CompletePurchaseResponse::class, $response);
        $this->assertEquals($transactionReference, $response->getTransactionReference());

        $this->assertTrue($response->isSuccessful());

        $this->assertFalse($response->isPaid());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isOpen());
        $this->assertFalse($response->isAuthorized());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isExpired());
        $this->assertTrue($response->isVerify());

        $this->assertEquals('VERIFY', $response->getStatus());

        $this->assertEquals(1, $response->getAmount(), 'Amount should be 1 USD');
        $this->assertEquals('USD', $response->getCurrency(), 'Amount should be 1 USD');
    }

    protected function setUp()
    {
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'tokenCode' => 'AT-1234-5678',
            'apiToken' => 'some-token',
            'serviceId' => 'SL-1234-5678'
        ]);
    }
}