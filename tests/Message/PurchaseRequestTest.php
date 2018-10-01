<?php

namespace Omnipay\Paynl\Test\Message;


use Omnipay\Common\CreditCard;
use Omnipay\Paynl\Message\Request\PurchaseRequest;
use Omnipay\Paynl\Message\Response\PurchaseResponse;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    protected $request;

    public function testSendSuccessMinimal()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $this->request->setAmount(1);
        $this->request->setClientIp('10.0.0.5');
        $this->request->setReturnUrl('https://www.pay.nl');

        $response = $this->request->send();
        $this->assertInstanceOf(PurchaseResponse::class, $response);

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());

        $this->assertInternalType('string', $response->getTransactionReference());
        $this->assertInternalType('string', $response->getRedirectUrl());
        $this->assertInternalType('string', $response->getAcceptCode());

        $this->assertEquals('GET', $response->getRedirectMethod());
        $this->assertNull($response->getRedirectData());
    }

    public function testSendSuccessWithCard()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $this->request->setAmount(1);
        $this->request->setClientIp('10.0.0.5');
        $this->request->setReturnUrl('https://www.pay.nl');
        $this->request->setNotifyUrl('https://www.pay.nl/exchange');

        $card = $this->getValidCard();
        $this->request->setCard(new CreditCard($card));

        $response = $this->request->send();

        $this->assertInstanceOf(PurchaseResponse::class, $response);

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());

        $this->assertInternalType('string', $response->getTransactionReference());
        $this->assertInternalType('string', $response->getRedirectUrl());
        $this->assertInternalType('string', $response->getAcceptCode());

        $this->assertEquals('GET', $response->getRedirectMethod());
        $this->assertNull($response->getRedirectData());
    }

    public function testSendSuccessWithItems()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $this->request->setAmount(1);
        $this->request->setClientIp('10.0.0.5');
        $this->request->setReturnUrl('https://www.pay.nl');
        $this->request->setNotifyUrl('https://www.pay.nl/exchange');

        $items = [];
        $items[] = new \Omnipay\Common\Item([
            'description' => 'Standard product',
            'price' => '0.50',
            'quantity' => '1'
        ]);
        $items[] = new \Omnipay\Paynl\Common\Item([
            'description' => 'Paynl Product',
            'price' => '0.25',
            'quantity' => '2',
            'productId' => 1234,
            'productType' => \Omnipay\Paynl\Common\Item::PRODUCT_TYPE_ARTICLE,
            'vatPercentage' => '21'
        ]);

        $this->request->setItems($items);

        $response = $this->request->send();

        $this->assertInstanceOf(PurchaseResponse::class, $response);

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());

        $this->assertInternalType('string', $response->getTransactionReference());
        $this->assertInternalType('string', $response->getRedirectUrl());
        $this->assertInternalType('string', $response->getAcceptCode());

        $this->assertEquals('GET', $response->getRedirectMethod());
        $this->assertNull($response->getRedirectData());
    }

    protected function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'tokenCode' => 'AT-1234-5678',
            'apiToken' => 'some-token',
            'serviceId' => 'SL-1234-5678'
        ]);
    }
}