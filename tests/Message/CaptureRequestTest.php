<?php

namespace Omnipay\Paynl\Test\Message;


use Omnipay\Common\Item;
use Omnipay\Paynl\Message\Request\CaptureRequest;
use Omnipay\Paynl\Message\Response\CaptureResponse;
use Omnipay\Tests\TestCase;

class CaptureRequestTest extends TestCase
{
    /**
     * @var CaptureRequest
     */
    protected $request;

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');

        $transactionId = uniqid();
        $this->request->setTransactionReference($transactionId);

        $response = $this->request->send();

        $this->assertInstanceOf(CaptureResponse::class, $response);

        $this->assertEquals($transactionId, $response->getTransactionReference());
        $this->assertTrue($response->isSuccessful());
        $this->assertEmpty($response->getMessage());
    }

    public function testStockProduct()
    {
        $transactionId = uniqid();
        $productName = uniqid();
        $quantity = rand(1, 10);

        $item = new Item([
            'name' => $productName,
            'quantity' => $quantity
        ]);

        $this->request->setTransactionReference($transactionId);
        $this->request->setItems([$item]);

        $data = $this->request->getData();

        $this->assertEquals($transactionId, $data['transactionId']);
        $this->assertNotEmpty($data['products']);
        $product = $data['products'][0];

        $this->assertEquals($productName, $product['productId']);
        $this->assertEquals($quantity, $product['quantity']);
    }

    public function testPaynlProduct()
    {
        $transactionId = uniqid();
        $productId = uniqid();
        $quantity = rand(1, 10);

        $item = new \Omnipay\Paynl\Common\Item([
            'productId' => $productId,
            'quantity' => $quantity
        ]);
        $this->request->setTransactionReference($transactionId);
        $this->request->setItems([$item]);

        $data = $this->request->getData();

        $this->assertEquals($transactionId, $data['transactionId']);
        $this->assertNotEmpty($data['products']);
        $product = $data['products'][0];

        $this->assertEquals($productId, $product['productId']);
        $this->assertEquals($quantity, $product['quantity']);
    }

    public function testTrackTrace()
    {
        $transactionId = uniqid();
        $trackTrace = uniqid();

        $this->request->setTransactionReference($transactionId);
        $this->request->setTrackTrace($trackTrace);

        $data = $this->request->getData();

        $this->assertEquals($transactionId, $data['transactionId']);
        $this->assertEquals($trackTrace, $data['tracktrace']);
    }

    public function testSendError()
    {
        $this->setMockHttpResponse('CaptureError.txt');

        $transactionId = uniqid();
        $this->request->setTransactionReference($transactionId);

        $response = $this->request->send();

        $this->assertInstanceOf(CaptureResponse::class, $response);

        $this->assertEquals($transactionId, $response->getTransactionReference());
        $this->assertFalse($response->isSuccessful());
        $this->assertNotEmpty($response->getMessage());
    }

    protected function setUp()
    {
        $this->request = new CaptureRequest($this->getHttpClient(), $this->getHttpRequest());

        $this->request->initialize([
            'tokenCode' => 'AT-1234-5678',
            'apiToken' => 'some-token'
        ]);
    }
}