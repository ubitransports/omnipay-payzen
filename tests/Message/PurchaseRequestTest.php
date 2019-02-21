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
            'certificate'               => '1122334455667788',
            'orderId'                   => '123',
            'successUrl'                => 'http://success',
            'cancelUrl'                 => 'http://cancel',
            'errorUrl'                  => 'http://error',
            'refusedUrl'                => 'http://refused',
            'notifyUrl'                 => 'http://notify',
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
        $this->assertSame('123', $data['vads_order_id']);
        $this->assertSame('http://success', $data['vads_url_success']);
        $this->assertSame('http://cancel', $data['vads_url_cancel']);
        $this->assertSame('http://error', $data['vads_url_error']);
        $this->assertSame('http://refused', $data['vads_url_refused']);
        $this->assertSame('2e8566261b46ea6081859a7af0ada9e1578debb8', $data['signature']);
    }

    public function testGetDataWithCustomData()
    {
        $this->request->setPaymentConfig(AbstractRequest::PAYMENT_CONFIG_MULTIPLE);
        $this->request->setPageAction(AbstractRequest::PAGE_ACTION_ASK_REGISTER_PAY);
        $this->request->setIdentifier('123456');
        $this->request->setIdentifierStatus(AbstractRequest::IDENTIFIER_STATUS_CREATED);

        $data = $this->request->getData();

        $this->assertSame(AbstractRequest::PAYMENT_CONFIG_MULTIPLE, $data['vads_payment_config']);
        $this->assertSame(AbstractRequest::PAGE_ACTION_ASK_REGISTER_PAY, $data['vads_page_action']);
        $this->assertSame('123456', $data['vads_identifier']);
        $this->assertSame(AbstractRequest::IDENTIFIER_STATUS_CREATED, $data['vads_identifier_status']);
    }
}
