<?php

namespace Omnipay\PayZen;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\PayZen\Message\PurchaseRequest', $request);
        $this->assertSame(1000, $request->getAmountInteger());
        $this->assertSame('PAYMENT', $request->getData()['vads_page_action']);
        $this->assertArrayNotHasKey('vads_identifier', $request->getData());
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase(array('amount' => '10.00'));

        $this->assertInstanceOf('Omnipay\PayZen\Message\CompletePurchaseRequest', $request);
        $this->assertSame(1000, $request->getAmountInteger());
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

    public function testCreateCard()
    {
        $request = $this->gateway->createCard(array());

        $this->assertInstanceOf('Omnipay\PayZen\Message\CreateCardRequest', $request);
        $this->assertSame('REGISTER', $request->getData()['vads_page_action']);
    }
}
