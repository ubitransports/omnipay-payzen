<?php

namespace Omnipay\PayZen\Message;

/**
 * PayZen Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
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
        $data['vads_page_action'] = $this->resolvePageAction();
        $data['vads_version'] = 'V2';
        $data['vads_payment_config'] = 'SINGLE';
        $data['vads_capture_delay'] = 0;
        $data['vads_validation_mode'] = 0;
        $data['vads_url_success'] = $this->getSuccessUrl();
        $data['vads_url_cancel'] = $this->getCancelUrl();
        $data['vads_url_error'] = $this->getErrorUrl();
        $data['vads_url_refused'] = $this->getRefusedUrl();
        $data['vads_order_id'] = $this->getOrderId();
        $data['vads_payment_cards'] = $this->getPaymentCards();
        $data['vads_ext_info_owner_reference'] = $this->getOwnerReference();

        if (null !== $this->getNotifyUrl()) {
            $data['vads_url_check'] = $this->getNotifyUrl();
        }

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

        $metadata = $this->getMetadata();
        if (!empty($metadata)) {
            foreach ($metadata as $key => $value) {
                $data['vads_ext_info_' . $key] = $value;
            }
        }

        if ($this->hasCardReference()) {
            $data['vads_identifier'] = $this->getCardReference();
        }

        $data['signature'] = $this->generateSignature($data);

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new RedirectToGatewayResponse($this, $data);
    }

    public function setCreateCard($value)
    {
        return $this->setParameter('createCard', $value);
    }

    public function isCreatingCard()
    {
        return true === $this->getParameter('createCard', false);
    }

    public function setCardReference($value)
    {
        return $this->setParameter('cardReference', $value);
    }

    public function getCardReference()
    {
        return $this->getParameter('cardReference');
    }

    public function hasCardReference()
    {
        return null !== $this->getCardReference();
    }

    private function resolvePageAction()
    {
        if ($this->isCreatingCard()
            && false === $this->hasCardReference()
        ) {
            return 'REGISTER_PAY';
        }

        return 'PAYMENT';
    }
}
