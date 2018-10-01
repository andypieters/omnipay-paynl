<?php

namespace Omnipay\Paynl\Test\Message;


use Omnipay\Common\Issuer;
use Omnipay\Paynl\Message\Request\FetchIssuersRequest;
use Omnipay\Paynl\Message\Response\FetchIssuersResponse;
use Omnipay\Tests\TestCase;

class FetchIssuersRequestTest extends TestCase
{
    /**
     * @var FetchIssuersRequest
     */
    protected $request;

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('FetchIssuersSuccess.txt');

        $response = $this->request->send();

        $this->assertInstanceOf(FetchIssuersResponse::class, $response);
        $this->assertTrue($response->isSuccessful());

        $issuers = $response->getIssuers();
        $this->assertInternalType('array', $issuers);
        $this->assertNotEmpty($issuers);

        $this->assertContainsOnlyInstancesOf(Issuer::class, $issuers);
    }

    protected function setUp()
    {
        $this->request = new FetchIssuersRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'tokenCode' => 'AT-1234-5678',
            'apiToken' => 'some-token'
        ]);
    }
}