<?php

namespace Omnipay\PayZen\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array();
        $data['vads_action_mode'] = 'INTERACTIVE';
        $data['vads_capture_delay'] = 0;
        $data['vads_ctx_mode'] = $this->getTestMode() ? 'TEST' : 'PRODUCTION';
        $data['vads_page_action'] = 'REGISTER';
        $data['vads_payment_cards'] = $this->getPaymentCards();
        $data['vads_site_id'] = $this->getMerchantId();
        $data['vads_url_cancel'] = $this->getCancelUrl();
        $data['vads_url_error'] = $this->getErrorUrl();
        $data['vads_url_refused'] = $this->getRefusedUrl();
        $data['vads_url_success'] = $this->getSuccessUrl();
        $data['vads_validation_mode'] = 0;
        $data['vads_version'] = 'V2';

        if ($this->getCard()) {
            $data['vads_cust_address'] = $this->getCard()->getAddress1();
            $data['vads_cust_city'] = $this->getCard()->getCity();
            $data['vads_cust_country'] = $this->getCard()->getCountry();
            $data['vads_cust_email'] = $this->getCard()->getEmail();
            $data['vads_cust_first_name'] = $this->getCard()->getName();
            $data['vads_cust_phone'] = $this->getCard()->getPhone();
            $data['vads_cust_state'] = $this->getCard()->getState();
            $data['vads_cust_zip'] = $this->getCard()->getPostcode();
        }

        $data['signature'] = $this->generateSignature($data);

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
