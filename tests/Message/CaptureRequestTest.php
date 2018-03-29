<?php


namespace Omnipay\Paynl\Message;

use Omnipay\Paynl\Common\Item;
use Omnipay\Common\Item as PlainItem;
use Omnipay\Tests\TestCase;
use Mockery as m;

class CaptureRequestTest extends TestCase
{
    /**
     * @var CaptureRequest
     */
    private $request;

    public function testGetData()
    {
        $this->request->setTransactionReference('123456789Xabcdef');
        $this->request->setAmount('5.00');

        $item = new Item();
        $item->setProductId('SKU-123');
        $item->setQuantity(1);

        $plainItem = new PlainItem();
        $plainItem->setName('SKU-456');
        $plainItem->setQuantity(2);

        $this->request->setItems(array($item, $plainItem));

        $data = $this->request->getData();
        $this->assertArrayHasKey('transactionId', $data);
        $this->assertArrayHasKey('amount', $data);
        $this->assertNotEmpty($data['transactionId']);
        $this->assertEquals(500,$data['amount']);
        $this->assertArrayHasKey('products', $data);
        $product = $data['products'][0];
        $this->assertArrayHasKey('productId', $product);
        $this->assertArrayHasKey('quantity', $product);
        $this->assertEquals('SKU-123', $product['productId']);
        $this->assertEquals('1', $product['quantity']);
    }
    public function testError(){
        $this->setMockHttpResponse('CaptureError.txt');

        $this->request->setTransactionReference('123456789Xabcdef');

        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertNotEmpty($response->getMessage());
    }
    public function testSuccess(){
        $this->setMockHttpResponse('CaptureSuccess.txt');

        $this->request->setTransactionReference('123456789Xabcdef');
        $this->request->setAmount('5.00');

        $response = $this->request->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEmpty($response->getMessage());
    }

    protected function setUp()
    {
        parent::setUp();

        $arguments = array($this->getHttpClient(), $this->getHttpRequest());

        $this->request = m::mock('Omnipay\Paynl\Message\CaptureRequest[getEndpoint]', $arguments);

        $this->request->setApitoken('123456789abcdefghijklmnop');
        $this->request->setServiceId('SL-1234-1234');
    }

}