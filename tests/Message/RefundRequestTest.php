<?php

namespace Omnipay\Paynl\Message;

use Mockery as m;
use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /**
     * @var RefundRequest
     */
    private $request;

    public function testExceptionNoLogin()
    {
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException');
        $this->request->getData();
    }

    public function testExceptionNoTransactionRef()
    {
        $this->request->setApitoken('your-token');
        $this->request->setServiceId('SL-1234-1234');
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException');
        $this->request->getData();
    }

    public function testWithAllOptions()
    {
        $this->request->setApitoken('your-token');
        $this->request->setServiceId('SL-1234-1234');
        $this->request->setTransactionReference('12345678xqwe');
        $this->request->setAmount(0.50);
        $this->request->setDescription('Voldoet niet aan verwachting');
        $data = $this->request->getData();
        $this->assertArrayHasKey('transactionId', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('amount', $data);
        $this->assertEquals('12345678xqwe', $data['transactionId']);
        $this->assertEquals('Voldoet niet aan verwachting', $data['description']);
        $this->assertEquals(50, $data['amount']);
    }

    public function testApiError(){
        $this->setMockHttpResponse('RefundError.txt');
        $this->request->setApitoken('your-token');
        $this->request->setServiceId('SL-1234-1234');
        $this->request->setTransactionReference('12345678xqwe');

        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertNotEmpty($response->getMessage());
        $this->assertNull($response->getTransactionReference());
    }
    public function testApiSuccess(){
        $this->setMockHttpResponse('RefundSuccess.txt');
        $this->request->setApitoken('your-token');
        $this->request->setServiceId('SL-1234-1234');
        $this->request->setTransactionReference('12345678xqwe');

        $response = $this->request->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertEquals('RF-1234-1234', $response->getTransactionReference());
        $this->assertEmpty($response->getMessage());
    }

    protected function setUp()
    {
        parent::setUp();

        $arguments     = array($this->getHttpClient(), $this->getHttpRequest());
        $this->request = m::mock('Omnipay\Paynl\Message\RefundRequest[getEndpoint]', $arguments);
    }
}
