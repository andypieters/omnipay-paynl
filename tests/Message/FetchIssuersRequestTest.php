<?php


namespace Omnipay\Paynl\Message;


use Mockery as m;
use Omnipay\Tests\TestCase;

class FetchIssuersRequestTest extends TestCase
{
    /**
     * @var FetchIssuersRequest
     */
    private $request;

    public function testApiError()
    {
        $this->setMockHttpResponse('GetServiceError.txt');

        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertNotEmpty($response->getMessage());
        $issuers = $response->getIssuers();
        $this->assertNull($issuers);
    }
    public function testApiSuccess()
    {
        $this->setMockHttpResponse('GetServiceSuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEmpty($response->getMessage());
        $issuers = $response->getIssuers();
        $this->assertNotEmpty($issuers);
        $this->assertInternalType('array', $issuers);

        $this->assertInstanceOf('Omnipay\Common\Issuer', $issuers[0]);
    }
    public function testApiNoIdealSuccess()
    {
        $this->setMockHttpResponse('GetServiceNoIdealSuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEmpty($response->getMessage());
        $issuers = $response->getIssuers();
        $this->assertNull($issuers);
    }


    protected function setUp()
    {
        parent::setUp();

        $arguments = array($this->getHttpClient(), $this->getHttpRequest());

        $this->request = m::mock('Omnipay\Paynl\Message\FetchIssuersRequest[getEndpoint]', $arguments);

        $this->request->setApitoken('123456789abcdefghijklmnop');
        $this->request->setServiceId('SL-1234-1234');
    }
}