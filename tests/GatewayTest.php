<?php
/**
 * Created by PhpStorm.
 * User: andypieters
 * Date: 24-09-18
 * Time: 19:46
 */

namespace Omnipay\Paynl\Test;

use Omnipay\Paynl\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway();
    }
}
