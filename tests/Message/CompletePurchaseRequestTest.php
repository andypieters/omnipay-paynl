<?php


namespace Omnipay\Paynl\Message;

use Mockery as m;
use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{

    /**
     * @var CompletePurchaseRequest
     */
    private $request;

    protected function setUp()
    {
        parent::setUp();

        $arguments = array($this->getHttpClient(), $this->getHttpRequest());
        $this->request = m::mock('Omnipay\Paynl\Message\CompletePurchaseRequest[getEndpoint]', $arguments);

        $this->request->setApitoken('123456789abcdefghijklmnop');
    }

    public function testExceptionNoTransactionId(){
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException');
        $this->request->getData();
    }

    public function testGetData(){
        $this->request->setTransactionReference('123456789Xabcde');

        $data = $this->request->getData();

        $this->assertArrayHasKey('transactionId', $data);
        $this->assertEquals('123456789Xabcde', $data['transactionId']);
    }

    public function testApiError(){
        $this->setMockHttpResponse('TransactionInfoError.txt');

        $this->request->setTransactionReference('123456789Xabcde');

        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertNotEmpty($response->getMessage());
    }
    public function testCanceled(){
        $this->setMockHttpResponse('TransactionInfoSuccessCanceled.txt');
        $this->request->setTransactionReference('123456789Xabcde');

        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertEmpty($response->getMessage());
    }
    public function testPaid(){
        $this->setMockHttpResponse('TransactionInfoSuccessPaid.txt');
        $this->request->setTransactionReference('123456789Xabcde');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
    }
}