<?php

namespace Omnipay\Paynl\Test\Message;


use Omnipay\Paynl\Message\Request\RefundRequest;
use Omnipay\Paynl\Message\Response\RefundResponse;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /**
     * @var RefundRequest
     */
    protected $request;

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('RefundSuccess.txt');

        $transactionId = uniqid();

        $this->request->setTransactionReference($transactionId);

        $response = $this->request->send();

        $this->assertInstanceOf(RefundResponse::class, $response);
        $this->assertEquals($transactionId, $response->getTransactionReference());
        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->getDescription());
        $this->assertInternalType('integer', $response->getAmountInteger());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('RefundError.txt');

        $transactionId = uniqid();

        $this->request->setTransactionReference($transactionId);

        $response = $this->request->send();

        $this->assertInstanceOf(RefundResponse::class, $response);
        $this->assertEquals($transactionId, $response->getTransactionReference());

        $this->assertFalse($response->isSuccessful());
        $this->assertNotEmpty($response->getMessage());
    }

    public function testAmount()
    {
        $transactionId = uniqid();
        $amount = rand(1, 100);

        $this->request->setTransactionReference($transactionId);
        $this->request->setAmountInteger($amount);

        $data = $this->request->getData();

        $this->assertEquals($transactionId, $data['transactionId']);
        $this->assertEquals($amount, $data['amount']);
    }

    public function testDescription()
    {
        $transactionId = uniqid();
        $description = uniqid();

        $this->request->setTransactionReference($transactionId);
        $this->request->setDescription($description);

        $data = $this->request->getData();

        $this->assertEquals($transactionId, $data['transactionId']);
        $this->assertEquals($description, $data['description']);
    }

    protected function setUp()
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'tokenCode' => 'AT-1234-1234',
            'apiToken' => 'some-token'
        ]);
    }
}