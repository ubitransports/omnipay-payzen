<?php

namespace Omnipay\PayZen\Message;

use DateTime;
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
            'shipToType' => 'ETICKET',
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
        $this->assertSame('ETICKET', $data['vads_ship_to_type']);
        $this->assertSame('http://success', $data['vads_url_success']);
        $this->assertSame('http://cancel', $data['vads_url_cancel']);
        $this->assertSame('http://error', $data['vads_url_error']);
        $this->assertSame('http://refused', $data['vads_url_refused']);
        $this->assertSame('6c8f14b7fb9d8bcaf34db14fb2021f9b2d7598f0', $data['signature']);
        $this->assertSame('1', $data['vads_ext_info_info1']);
        $this->assertSame('2', $data['vads_ext_info_info2']);
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
            'shipToType' => 'ETICKET',
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
        $this->assertSame('ETICKET', $data['vads_ship_to_type']);
        $this->assertSame('http://success', $data['vads_url_success']);
        $this->assertSame('http://cancel', $data['vads_url_cancel']);
        $this->assertSame('http://error', $data['vads_url_error']);
        $this->assertSame('http://refused', $data['vads_url_refused']);
        $this->assertSame('acbecc5eae87decfeae5c0228d6cb66dfd7ab6f3', $data['signature']);
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
            'shipToType' => 'ETICKET',
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
        $this->assertSame('ETICKET', $data['vads_ship_to_type']);
        $this->assertSame('http://success', $data['vads_url_success']);
        $this->assertSame('http://cancel', $data['vads_url_cancel']);
        $this->assertSame('http://error', $data['vads_url_error']);
        $this->assertSame('http://refused', $data['vads_url_refused']);
        $this->assertSame('73f231e768cfaafc3ccf0f9b63cf58dd972b3c64', $data['signature']);
        $this->assertSame('1', $data['vads_ext_info_info1']);
        $this->assertSame('2', $data['vads_ext_info_info2']);
        $this->assertSame(3, $data['vads_redirect_success_timeout']);
        $this->assertSame(5, $data['vads_redirect_error_timeout']);
    }

    public function testSetPaymentConfigMulti()
    {
        $this->request->setPaymentConfig('MULTI', ['first' => 10.0, 'count' => 2, 'period' => 5]);
        $this->assertEquals('MULTI:first=1000;count=2;period=5', $this->request->getPaymentConfig());
    }

    /**
     * @expectedException Omnipay\Common\Exception\InvalidRequestException
     */
    public function testSetPaymentConfigMulti_ShouldThrowAnException()
    {
        // Missing argument 'first'
        $this->request->setPaymentConfig('MULTI', ['count' => 2, 'period' => 5]);

        // argument first must be a floatval
        $this->request->setPaymentConfig('MULTI', ['first' => 10, 'count' => 2, 'period' => 5]);

        // argument count must be an integer greater than PurchaseRequest::TYPE_MULTI_MIN_INSTALLMENTS
        $this->request->setPaymentConfig('MULTI', ['first' => 10, 'count' => 1, 'period' => 5]);

        // argument period must be an integer greater than PurchaseRequest::TYPE_MULTI_MIN_DAYS_BTW_PERIOD
        $this->request->setPaymentConfig('MULTI', ['first' => 10, 'count' => 3, 'period' => 0]);
    }

    public function testSetPaymentConfigMultiExt()
    {
        $this->request->setAmount(33.0);

        $values = [
            (new DateTime())->format('Ymd') => 12.0,
            (new DateTime('+15 days'))->format('Ymd') => 11.0,
            (new DateTime('+30 days'))->format('Ymd') => 10.0
        ];

        $dates = array_keys($values);

        $this->request->setPaymentConfig('MULTI_EXT', $values);
        $this->assertEquals('MULTI_EXT:'.$dates[0].'=1200;'.$dates[1].'=1100;'.$dates[2].'=1000', $this->request->getPaymentConfig());
    }

    /**
     * @expectedException Omnipay\Common\Exception\InvalidRequestException
     */
    public function testSetPaymentConfigMultiExt_ShouldThrowAnException()
    {
        $this->request->setAmount(33.0);

        // Invalid past date
        $values = [
            (new DateTime())->format('Ymd') => 12.0,
            (new DateTime('-2 days'))->format('Ymd') => 11.0,
            (new DateTime('+30 days'))->format('Ymd') => 10.0
        ];

        $this->request->setPaymentConfig('MULTI_EXT', $values);

        // Sum of amounts doesn't match with the total
        $this->request->setAmount(30.0);
        $values = [
            (new DateTime())->format('Ymd') => 12.0,
            (new DateTime('-15 days'))->format('Ymd') => 11.0,
            (new DateTime('+30 days'))->format('Ymd') => 10.0
        ];

        $this->request->setPaymentConfig('MULTI_EXT', $values);
    }

    /**
     * @expectedException Omnipay\Common\Exception\InvalidRequestException
     */
    public function testSetShipToType_ShouldThrowAnException()
    {
        $this->request->setShipToType('UNKNOWN');
    }
}
