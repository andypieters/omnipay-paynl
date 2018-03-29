<?php


namespace Omnipay\Paynl\Message;

use Mockery as m;
use Omnipay\Tests\TestCase;

class FetchPaymentMethodsRequestTest extends TestCase
{

    /**
     * @var FetchPaymentMethodsRequest
     */
    private $request;

    public function testApiError()
    {
        $this->setMockHttpResponse('GetServiceError.txt');

        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertNotEmpty($response->getMessage());
        $this->assertNull($response->getPaymentMethods());
    }
    public function testApiSuccess()
    {
        $this->setMockHttpResponse('GetServiceSuccess.txt');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEmpty($response->getMessage());

        $paymentMethods = $response->getPaymentMethods();
        $this->assertNotEmpty($paymentMethods);
        $this->assertInternalType('array', $paymentMethods);
        $this->assertInstanceOf('Omnipay\Common\PaymentMethod', $paymentMethods[0]);
    }
    protected function setUp()
    {
        parent::setUp();

        $arguments = array($this->getHttpClient(), $this->getHttpRequest());

        $this->request = m::mock('Omnipay\Paynl\Message\FetchPaymentMethodsRequest[getEndpoint]', $arguments);

        $this->request->setApitoken('123456789abcdefghijklmnop');
        $this->request->setServiceId('SL-1234-1234');
    }
}