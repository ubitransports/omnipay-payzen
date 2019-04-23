<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * PayZen Complete Purchase Response
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->getTransactionStatus() == 'AUTHORISED';
    }

    public function getTransactionReference()
    {
        return isset($this->data['vads_trans_id']) ? $this->data['vads_trans_id'] : null;
    }

    public function getOrderId()
    {
        return isset($this->data['vads_order_id']) ? $this->data['vads_order_id'] : null;
    }

    public function getAmount()
    {
        return isset($this->data['vads_amount']) ? $this->data['vads_amount'] / 100 : null;
    }

    public function getTransactionDate()
    {
        return isset($this->data['vads_trans_date']) ? $this->data['vads_trans_date'] : null;
    }

    public function getTransactionStatus()
    {
        return isset($this->data['vads_trans_status']) ? $this->data['vads_trans_status'] : null;
    }

    public function getCode()
    {
        return isset($this->data['vads_result']) ? $this->data['vads_result'] : null;
    }

    public function getUuid()
    {
        return isset($this->data['vads_trans_uuid']) ? $this->data['vads_trans_uuid'] : null;
    }

    public function hasCreatedCard()
    {
        if (isset($this->data['vads_identifier_status'])
            && 'CREATED' ===  $this->data['vads_identifier_status']
        ) {
            return true;
        }

        return false;
    }

    public function getCardReference()
    {
        return isset($this->data['vads_identifier']) ? $this->data['vads_identifier'] : null;
    }

    public function getCardNumber()
    {
        return isset($this->data['vads_card_number']) ? $this->data['vads_card_number'] : null;
    }

    public function getCardExpiryDate()
    {
        if (!isset($this->__data['vads_expiry_year'])
            || !isset($this->__data['vads_expiry_month'])
        ) {
            return null;
        }

        return \DateTime::createFromFormat(
            'Y-m',
            sprintf('%s-%s', $this->__data['vads_expiry_year'], $this->__data['vads_expiry_month'])
        );
    }

    public function getCardBrand()
    {
        return isset($this->data['vads_card_brand']) ? $this->data['vads_card_brand'] : null;
    }
}
