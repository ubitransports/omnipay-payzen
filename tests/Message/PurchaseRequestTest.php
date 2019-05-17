<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetPurchaseData()
    {
        $this->request->initialize(array(
            'merchantId' => '12345678',
            'transactionId' => '654321',
            'amount' => '15.24',
            'currency' => 'EUR',
            'testMode' => true,
            'transactionDate' => '20090501193530',
            'certificate' => '1122334455667788',
            'orderId' => '123',
            'successUrl' => 'http://success',
            'cancelUrl' => 'http://cancel',
            'errorUrl' => 'http://error',
            'refusedUrl' => 'http://refused',
            'notifyUrl' => 'http://notify',
        ));
        $data = $this->request->getData();

        $this->assertSame('1524', $data['vads_amount']);
        $this->assertSame('12345678', $data['vads_site_id']);
        $this->assertSame('978', $data['vads_currency']);
        $this->assertSame('INTERACTIVE', $data['vads_action_mode']);
        $this->assertSame('TEST', $data['vads_ctx_mode']);
        $this->assertSame('PAYMENT', $data['vads_page_action']);
        $this->assertSame('SINGLE', $data['vads_payment_config']);
        $this->assertSame('V2', $data['vads_version']);
        $this->assertSame('654321', $data['vads_trans_id']);
        $this->assertSame('20090501193530', $data['vads_trans_date']);
        $this->assertSame('123', $data['vads_order_id']);
        $this->assertSame('http://success', $data['vads_url_success']);
        $this->assertSame('http://cancel', $data['vads_url_cancel']);
        $this->assertSame('http://error', $data['vads_url_error']);
        $this->assertSame('http://refused', $data['vads_url_refused']);
        $this->assertSame('e12cdfc3a121c7f49446bab00c98d2072da98633', $data['signature']);
    }

    public function testGetRegisterPayData()
    {
        $this->request->initialize(array(
            'merchantId' => '12345678',
            'transactionId' => '654321',
            'amount' => '15.24',
            'currency' => 'EUR',
            'testMode' => true,
            'transactionDate' => '20090501193530',
            'certificate' => '1122334455667788',
            'orderId' => '123',
            'successUrl' => 'http://success',
            'cancelUrl' => 'http://cancel',
            'errorUrl' => 'http://error',
            'refusedUrl' => 'http://refused',
            'notifyUrl' => 'http://notify',
            'createCard' => true,
            'ownerReference' => 'a owner reference',
        ));
        $data = $this->request->getData();

        $this->assertSame('1524', $data['vads_amount']);
        $this->assertSame('12345678', $data['vads_site_id']);
        $this->assertSame('978', $data['vads_currency']);
        $this->assertSame('INTERACTIVE', $data['vads_action_mode']);
        $this->assertSame('TEST', $data['vads_ctx_mode']);
        $this->assertSame('REGISTER_PAY', $data['vads_page_action']);
        $this->assertSame('SINGLE', $data['vads_payment_config']);
        $this->assertSame('V2', $data['vads_version']);
        $this->assertSame('654321', $data['vads_trans_id']);
        $this->assertSame('20090501193530', $data['vads_trans_date']);
        $this->assertSame('123', $data['vads_order_id']);
        $this->assertSame('http://success', $data['vads_url_success']);
        $this->assertSame('http://cancel', $data['vads_url_cancel']);
        $this->assertSame('http://error', $data['vads_url_error']);
        $this->assertSame('http://refused', $data['vads_url_refused']);
        $this->assertSame('7eeb7f33a7fe5631b5327c26118b50a5d04880ee', $data['signature']);
        $this->assertSame('a owner reference', $data['vads_ext_info_owner_reference']);
    }

    public function testGetRegisterPayWithCardReferenceData()
    {
        $this->request->initialize(array(
            'merchantId' => '12345678',
            'transactionId' => '654321',
            'amount' => '15.24',
            'currency' => 'EUR',
            'testMode' => true,
            'transactionDate' => '20090501193530',
            'certificate' => '1122334455667788',
            'orderId' => '123',
            'successUrl' => 'http://success',
            'cancelUrl' => 'http://cancel',
            'errorUrl' => 'http://error',
            'refusedUrl' => 'http://refused',
            'notifyUrl' => 'http://notify',
            'createCard' => true,
            'cardReference' => 'asuperidentifier',
        ));
        $data = $this->request->getData();

        $this->assertSame('1524', $data['vads_amount']);
        $this->assertSame('12345678', $data['vads_site_id']);
        $this->assertSame('978', $data['vads_currency']);
        $this->assertSame('INTERACTIVE', $data['vads_action_mode']);
        $this->assertSame('TEST', $data['vads_ctx_mode']);
        $this->assertSame('PAYMENT', $data['vads_page_action']);
        $this->assertSame('SINGLE', $data['vads_payment_config']);
        $this->assertSame('V2', $data['vads_version']);
        $this->assertSame('654321', $data['vads_trans_id']);
        $this->assertSame('20090501193530', $data['vads_trans_date']);
        $this->assertSame('123', $data['vads_order_id']);
        $this->assertSame('http://success', $data['vads_url_success']);
        $this->assertSame('http://cancel', $data['vads_url_cancel']);
        $this->assertSame('http://error', $data['vads_url_error']);
        $this->assertSame('http://refused', $data['vads_url_refused']);
        $this->assertSame('42180e7e0ef0059611357609f3ae164099c55af7', $data['signature']);
    }
}
