<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Tests\TestCase;

class CompleteCardCreationResponseTest extends TestCase
{
    public function testConstruct()
    {
        $identifier = 'asuperidentifier';
        $cardNumber = 'asupercardnumber';
        $cardBrand = 'CB';
        $expireAt = new \DateTime('2048-06-30');
        $metadata = array(
            'metadata_1' => 'Lorem',
            'metadata_2' => 'Ipsum'
        );
        $response = new CompleteCardCreationResponse($this->getMockRequest(), array(
            'signature' => '3132f1e451075f2408cda41f2e647e9b4747d421',
            'vads_amount' => '0',
            'vads_auth_mode' => 'MARK',
            'vads_auth_number' => 'asuperauthnumber',
            'vads_auth_result' => '0',
            'vads_bank_label' => 'asuperbanklabel',
            'vads_bank_product' => '1',
            'vads_card_brand' => $cardBrand,
            'vads_card_country' => 'FR',
            'vads_card_number' => $cardNumber,
            'vads_ctx_mode' => 'TEST',
            'vads_cust_email' => 'the.buyer@email.toot',
            'vads_expiry_month' => $expireAt->format('m'),
            'vads_expiry_year' => $expireAt->format('Y'),
            'vads_identifier' => $identifier,
            'vads_identifier_status' => 'CREATED',
            'vads_operation_type' => 'VERIFICATION',
            'vads_page_action' => 'REGISTER',
            'vads_risk_assessment_result' => 'ENABLE_3DS',
            'vads_site_id' => '1',
            'vads_threeds_enrolled' => 'Y',
            'vads_threeds_status' => 'Y',
            'vads_trans_id' => 'thetransid',
            'vads_trans_status' => 'ACCEPTED',
            'vads_trans_uuid' => 'thetransuuid',
            'vads_ext_info_metadata_1' => 'Lorem',
            'vads_ext_info_metadata_2' => 'Ipsum'
        ));


        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());

        $this->assertTrue($response->hasCreatedCard());
        $this->assertSame($identifier, $response->getCardReference());
        $this->assertSame($cardNumber, $response->getCardNumber());
        $this->assertEquals($expireAt, $response->getCardExpiryDate());
        $this->assertSame($cardBrand, $response->getCardBrand());
        $this->assertSame($metadata, $response->getMetadata());
    }
}
