<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tests\TestCase;

class RestPurchaseRequestTest extends TestCase
{
    private RestPurchaseRequest $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new RestPurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetDataMissingAmount()
    {
        $this->request->initialize([
            'testMode' => false,
            'username' => 'michel',
            'password' => 'mypassword',
            'testPassword' => 'test_mypassword',
        ]);


        $this->expectException(InvalidRequestException::class);

        $this->request->getData();
    }

    public function getDataMissingCurrency(): void
    {
        $this->request->initialize([
            'testMode' => false,
            'username' => 'michel',
            'password' => 'mypassword',
            'testPassword' => 'test_mypassword',
            'amount' => '14.32',
        ]);

        $this->expectException(InvalidRequestException::class);

        $this->request->getData();
    }

    /**
     * @throws InvalidRequestException
     */
    public function testGetDataNoCustomer()
    {
        $testMode = false;
        $username = 'michel';
        $password = 'mypassword';
        $testPassword = 'test_mypassword';
        $amount = '14.32';
        $currency = 'EUR';
        $this->request->initialize(compact(
            'testMode',
            'username',
            'password',
            'testPassword',
            'amount',
            'currency'
        ));

        $data = $this->request->getData();

        $this->assertEquals($amount*100, $data['amount']);
        $this->assertSame($currency, $data['currency']);
    }

    /**
     * @throws InvalidRequestException
     */
    public function testGetDataWithCustomer()
    {
        $testMode = false;
        $username = 'michel';
        $password = 'mypassword';
        $testPassword = 'test_mypassword';
        $amount = '14.32';
        $currency = 'EUR';
        $card = [
            'firstName' => 'Jean-Michel',
            'lastName' => 'Theone',
            'email' => 'jm@theone.com'
        ];

        $this->request->initialize(compact(
            'testMode',
            'username',
            'password',
            'testPassword',
            'amount',
            'currency',
            'card'
        ));

        $data = $this->request->getData();

        $this->assertEquals($amount*100, $data['amount']);
        $this->assertSame($currency, $data['currency']);
        $this->assertEquals($card['lastName'], $data['customer']['billingDetails']['lastName']);
        $this->assertEquals($card['firstName'], $data['customer']['billingDetails']['firstName']);
        $this->assertEquals($card['email'], $data['customer']['email']);
        $this->assertEquals('PAYMENT', $data['formAction']);
    }

    /**
     * @throws InvalidRequestException
     */
    public function testGetDataWithCardReferenceAndNoForm()
    {
        $testMode = false;
        $username = 'michel';
        $password = 'mypassword';
        $testPassword = 'test_mypassword';
        $amount = '14.32';
        $currency = 'EUR';
        $card = [
            'firstName' => 'Jean-Michel',
            'lastName' => 'Theone',
            'email' => 'jm@theone.com'
        ];
        $withForm = false;

        $cardReference = "1657ed1ze68fez6";

        $this->request->initialize(compact(
            'testMode',
            'username',
            'password',
            'testPassword',
            'amount',
            'currency',
            'card',
            'cardReference',
            'withForm'
        ));

        $data = $this->request->getData();

        $this->assertEquals($amount*100, $data['amount']);
        $this->assertSame($currency, $data['currency']);
        $this->assertEquals($card['lastName'], $data['customer']['billingDetails']['lastName']);
        $this->assertEquals($card['firstName'], $data['customer']['billingDetails']['firstName']);
        $this->assertEquals($card['email'], $data['customer']['email']);
        $this->assertSame($cardReference, $data['paymentMethodToken']);
        $this->assertEquals('SILENT', $data['formAction']);
    }
}
