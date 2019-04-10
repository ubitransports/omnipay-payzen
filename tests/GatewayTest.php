<?php

namespace Omnipay\PayZen;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\PayZen\Message\PurchaseRequest', $request);
        $this->assertSame('1000', $request->getAmount());
        $this->assertSame('PAYMENT', $request->getData()['vads_page_action']);
        $this->assertArrayNotHasKey('vads_identifier', $request->getData());
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\PayZen\Message\CompletePurchaseRequest', $request);
        $this->assertSame('1000', $request->getAmount());
    }

    public function testPurchaseCreatingCard()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00', 'createCard' => true));

        $this->assertInstanceOf('Omnipay\PayZen\Message\PurchaseRequest', $request);
        $this->assertSame('REGISTER_PAY', $request->getData()['vads_page_action']);
        $this->assertArrayNotHasKey('vads_identifier', $request->getData());
    }

    public function testPurchaseByCardReference()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00', 'cardReference' => 'a card reference'));

        $this->assertInstanceOf('Omnipay\PayZen\Message\PurchaseRequest', $request);
        $this->assertSame('PAYMENT', $request->getData()['vads_page_action']);
        $this->assertSame('a card reference', $request->getData()['vads_identifier']);
    }
}
