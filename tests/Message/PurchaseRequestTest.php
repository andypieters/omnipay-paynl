<?php


namespace Omnipay\Paynl\Message;


use Mockery as m;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Item as PlainItem;
use Omnipay\Paynl\Common\Item;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function testWithItems()
    {
        $arrItems = array();

        $item = new Item();
        $item->setProductId('SKU01234')
             ->setProductType(Item::PRODUCT_TYPE_ARTICLE)
             ->setVatPercentage(21)
             ->setDescription('Description')
             ->setName('Pay item')
             ->setPrice('2.50')
             ->setQuantity(4);
        $arrItems[] = $item;

        $item = new PlainItem();
        $item->setDescription('Description')
             ->setName('Plain item')
             ->setPrice('2.50')
             ->setQuantity(4);
        $arrItems[] = $item;


        $this->request->setItems($arrItems);

        $data = $this->request->getData();
        $this->assertArrayHasKey('saleData', $data);
        $this->assertArrayHasKey('orderData', $data['saleData']);
    }

    public function testSuccessIdeal()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $this->request->setPaymentMethod(10);
        $this->request->setIssuer(1);

        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotEmpty($response->getRedirectUrl());
        $this->assertEquals('GET', $response->getRedirectMethod());
        $this->assertNull($response->getRedirectData());
        $this->assertEmpty($response->getMessage());
    }

    public function testErrorIdeal()
    {
        $this->setMockHttpResponse('PurchaseError.txt');
        $this->request->setPaymentMethod(999); // non existent payment method
        $this->request->setIssuer(1);

        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEmpty($response->getRedirectUrl());

        $this->assertNotEmpty($response->getMessage());
    }

    protected function setUp()
    {
        parent::setUp();

        $arguments = array($this->getHttpClient(), $this->getHttpRequest());

        $this->request = m::mock('Omnipay\Paynl\Message\PurchaseRequest[getEndpoint]', $arguments);

        $card = new CreditCard($this->getValidCard());

        $this->request->setCard($card);
        $this->request->setApitoken('token');
        $this->request->setAmount('10.00');
        $this->request->setDescription('description');
        $this->request->setServiceId('SL-1234-5678');
        $this->request->setReturnUrl('http://localhost/return');
        $this->request->setNotifyUrl('http://localhost/notify');

    }
}