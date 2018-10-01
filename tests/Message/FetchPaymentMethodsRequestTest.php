<?php

namespace Omnipay\Paynl\Test\Message;


use Omnipay\Common\PaymentMethod;
use Omnipay\Paynl\Message\Request\FetchPaymentMethodsRequest;
use Omnipay\Paynl\Message\Response\FetchPaymentMethodsResponse;
use Omnipay\Tests\TestCase;

class FetchPaymentMethodsRequestTest extends TestCase
{
    /**
     * @var FetchPaymentMethodsRequest
     */
    protected $request;

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('FetchPaymentMethodsSuccess.txt');

        $response = $this->request->send();

        $this->assertInstanceOf(FetchPaymentMethodsResponse::class, $response);
        $this->assertTrue($response->isSuccessful());

        $paymentMethods = $response->getPaymentMethods();

        $this->assertInternalType('array', $paymentMethods);
        $this->assertNotEmpty($paymentMethods);
        $this->assertContainsOnlyInstancesOf(PaymentMethod::class, $paymentMethods);
    }

    protected function setUp()
    {
        $this->request = new FetchPaymentMethodsRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'tokenCode' => 'AT-1234-5678',
            'apiToken' => 'some-token',
            'serviceId' => 'SL-1234-5678'
        ]);
    }
}