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
}
