<?php

namespace Omnipay\Paynl\Test\Message;


use Omnipay\Paynl\Message\Request\VoidRequest;
use Omnipay\Paynl\Message\Response\VoidResponse;
use Omnipay\Tests\TestCase;

class VoidRequestTest extends TestCase
{
    /**
     * @var VoidRequest
     */
    protected $request;

    public function testTransactionId()
    {
        $transactionId = uniqid();

        $this->request->setTransactionReference($transactionId);

        $data = $this->request->getData();

        $this->assertEquals($transactionId, $data['transactionId']);
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('VoidSuccess.txt');

        $transactionId = uniqid();

        $this->request->setTransactionReference($transactionId);

        $response = $this->request->send();

        $this->assertInstanceOf(VoidResponse::class, $response);
        $this->assertEquals($transactionId, $response->getTransactionReference());
        $this->assertTrue($response->isSuccessful());
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('VoidError.txt');

        $transactionId = uniqid();

        $this->request->setTransactionReference($transactionId);

        $response = $this->request->send();

        $this->assertInstanceOf(VoidResponse::class, $response);
        $this->assertEquals($transactionId, $response->getTransactionReference());
        $this->assertFalse($response->isSuccessful());
        $this->assertNotEmpty($response->getMessage());
    }

    protected function setUp()
    {
        $this->request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'tokenCode' => 'AT-1234-1234',
            'apiToken' => 'some-token'
        ]);
    }
}