<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * PayZen Complete Card Creation Response
 */
class CompleteCardCreationResponse extends AbstractResponse implements CardCreationResponseInterface
{
    use GetCardInformationTrait;

    use GetMetadataTrait;

    public function isSuccessful()
    {
        return $this->getTransactionStatus() == 'ACCEPTED';
    }

    public function getTransactionReference()
    {
        return isset($this->data['vads_trans_id']) ? $this->data['vads_trans_id'] : null;
    }

    public function getAmount()
    {
        return isset($this->data['vads_amount']) ? $this->data['vads_amount']: null;
    }

    public function getTransactionStatus()
    {
        return isset($this->data['vads_trans_status']) ? $this->data['vads_trans_status'] : null;
    }

    public function getUuid()
    {
        return isset($this->data['vads_trans_uuid']) ? $this->data['vads_trans_uuid'] : null;
    }
}
