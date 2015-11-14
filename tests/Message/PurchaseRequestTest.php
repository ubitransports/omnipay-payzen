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
        $this->request->initialize(array(
            'merchantId'                => '12345678',
            'transactionId'             => '654321',
            'amount'                    => '15.24',
            'currency'                  => 'EUR',
            'testMode'                  => true,
            'transactionDate'           => '20090501193530',
            'certificate'               => '1122334455667788'
        ));
    }

    public function testGetData()
    {
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
        $this->assertSame('681cb2b21fc412c4ac56ba6d7db1ef15250fba84', $data['signature']);
    }
}
