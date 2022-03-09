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
            'metadata' => array(
                'info1' => '1',
                'info2' => '2'
            ),
            'redirectSuccessTimeout' => 3,
            'redirectErrorTimeout' => 5
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
        $this->assertSame('c7779129a35f43bc204c5e37a6782160ef35ef44', $data['signature']);
        $this->assertSame('1', $data['vads_ext_info_info1']);
        $this->assertSame('2', $data['vads_ext_info_info2']);
        $this->assertSame(3, $data['vads_redirect_success_timeout']);
        $this->assertSame(5, $data['vads_redirect_error_timeout']);
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
            'metadata' => array(
                'info1' => '1',
                'info2' => '2'
            ),
            'redirectSuccessTimeout' => 3,
            'redirectErrorTimeout' => 5
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
        $this->assertSame('4cbe6302811fcf57235c5f6b60b33c153e4bb852', $data['signature']);
        $this->assertSame('a owner reference', $data['vads_ext_info_owner_reference']);
        $this->assertSame('1', $data['vads_ext_info_info1']);
        $this->assertSame('2', $data['vads_ext_info_info2']);
        $this->assertSame(3, $data['vads_redirect_success_timeout']);
        $this->assertSame(5, $data['vads_redirect_error_timeout']);
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
            'metadata' => array(
                'info1' => '1',
                'info2' => '2'
            ),
            'redirectSuccessTimeout' => 3,
            'redirectErrorTimeout' => 5
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
        $this->assertSame('338634eeb4cf969a37088259c5a985a3386a5f20', $data['signature']);
        $this->assertSame('1', $data['vads_ext_info_info1']);
        $this->assertSame('2', $data['vads_ext_info_info2']);
        $this->assertSame(3, $data['vads_redirect_success_timeout']);
        $this->assertSame(5, $data['vads_redirect_error_timeout']);
    }
}
