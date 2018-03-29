<?php


namespace Omnipay\Paynl\Message;

use Mockery as m;
use Omnipay\Tests\TestCase;


class FetchTransactionTest extends TestCase
{
    /**
     * @var FetchTransactionRequest
     */
    private $request;

    public function testExceptionNoTransactionId()
    {
        $this->setExpectedException('Omnipay\Common\Exception\InvalidRequestException');
        $this->request->getData();
    }

    public function testGetData()
    {
        $this->request->setTransactionReference('123456789Xabcde');

        $data = $this->request->getData();

        $this->assertArrayHasKey('transactionId', $data);
        $this->assertEquals('123456789Xabcde', $data['transactionId']);
    }

    public function testApiError()
    {
        $this->setMockHttpResponse('TransactionInfoError.txt');

        $this->request->setTransactionReference('123456789Xabcde');

        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertNotEmpty($response->getMessage());
    }

    public function testCanceled()
    {
        $this->setMockHttpResponse('TransactionInfoSuccessCanceled.txt');
        $this->request->setTransactionReference('123456789Xabcde');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEmpty($response->getMessage());

        $this->assertNotEmpty($response->getStatus());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertInternalType('bool', $response->isCancelled());
        $this->assertTrue($response->isCancelled());
        $this->assertInternalType('bool', $response->isExpired());
        $this->assertInternalType('bool', $response->isOpen());
        $this->assertInternalType('bool', $response->isPaid());
        $this->assertInternalType('bool', $response->isPending());
        $this->assertEquals(0, $response->getAmount());

    }

    public function testPaid()
    {
        $this->setMockHttpResponse('TransactionInfoSuccessPaid.txt');
        $this->request->setTransactionReference('123456789Xabcde');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEmpty($response->getMessage());

        $this->assertNotEmpty($response->getStatus());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertInternalType('bool', $response->isCancelled());
        $this->assertFalse($response->isCancelled());
        $this->assertInternalType('bool', $response->isExpired());
        $this->assertInternalType('bool', $response->isOpen());
        $this->assertInternalType('bool', $response->isPaid());
        $this->assertTrue($response->isPaid());
        $this->assertInternalType('bool', $response->isPending());
        $this->assertGreaterThan(0, $response->getAmount());
    }

    protected function setUp()
    {
        parent::setUp();

        $arguments     = array($this->getHttpClient(), $this->getHttpRequest());
        $this->request = m::mock('Omnipay\Paynl\Message\FetchTransactionRequest[getEndpoint]', $arguments);

        $this->request->setApitoken('123456789abcdeFfghijklmnop');
    }
}