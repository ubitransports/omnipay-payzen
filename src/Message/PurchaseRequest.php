<?php

namespace Omnipay\PayZen\Message;

/**
 * PayZen Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{

    /**
     *
     */
    public function getData()
    {
        $this->validate('amount');

        $data = array();
        $data['vads_site_id'] = $this->getMerchantId();
        $data['vads_ctx_mode'] = $this->getTestMode() ? 'TEST' : 'PRODUCTION';
        $data['vads_trans_id'] = $this->getTransactionId();
        $data['vads_trans_date'] = $this->getTransactionDate();
        $data['vads_amount'] = $this->getAmount();
        $data['vads_currency'] = $this->getCurrencyNumeric();
        $data['vads_action_mode'] = 'INTERACTIVE';
        $data['vads_page_action'] = 'PAYMENT';
        $data['vads_version'] = 'V2';
        $data['vads_payment_config'] = 'SINGLE';
        $data['vads_capture_delay'] = 0;
        $data['vads_validation_mode'] = 0;
        $data['vads_url_success'] = $this->getSuccessUrl();
        $data['vads_url_cancel'] = $this->getCancelUrl();
        $data['vads_url_error'] = $this->getErrorUrl();
        $data['vads_url_refused'] = $this->getRefusedUrl();
        $data['vads_order_id'] = $this->getOrderId();

        // Customer infos
        if ($this->getCard()) {
            $data['vads_cust_first_name'] = $this->getCard()->getName();
            $data['vads_cust_address'] = $this->getCard()->getAddress1();
            $data['vads_cust_city'] = $this->getCard()->getCity();
            $data['vads_cust_state'] = $this->getCard()->getState();
            $data['vads_cust_zip'] = $this->getCard()->getPostcode();
            $data['vads_cust_country'] = $this->getCard()->getCountry();
            $data['vads_cust_phone'] = $this->getCard()->getPhone();
            $data['vads_cust_email'] = $this->getCard()->getEmail();
        }

        /*

        // Order infos
        $data['vads_order_id'] = 1;
        $data['vads_order_info'] = 'Order description';
        $data['vads_nb_products'] = 1;
        // For each product
        $data['vads_product_label0'] = 1;
        $data['vads_product_amount0'] = 1;
        $data['vads_product_type0'] = 'TRAVEL';
        $data['vads_product_ref0'] = 1;
        $data['vads_product_qty0'] = 1;
        $data['vads_product_vat0'] = 1;

        $data['vads_url_return'] = 'http://mywebsite.com/return';
        $data['vads_return_mode'] = 'POST';

        */

        $data['signature'] = $this->generateSignature($data);

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
