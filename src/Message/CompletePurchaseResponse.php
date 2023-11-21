<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * PayZen Complete Purchase Response
 */
class CompletePurchaseResponse extends AbstractResponse implements CardCreationResponseInterface
{
    use GetCardInformationTrait;

    use GetMetadataTrait;

    public function isSuccessful(): bool
    {
        return in_array($this->getTransactionStatus(), ['AUTHORISED', 'CAPTURED']);
    }

    public function getTransactionReference()
    {
        return $this->data['vads_trans_id'] ?? null;
    }

    public function getOrderId()
    {
        return $this->data['vads_order_id'] ?? null;
    }

    public function getAmount(): float|int|null
    {
        return isset($this->data['vads_amount']) ? $this->data['vads_amount'] / 100 : null;
    }

    public function getTransactionDate()
    {
        return $this->data['vads_trans_date'] ?? null;
    }

    public function getTransactionStatus()
    {
        return $this->data['vads_trans_status'] ?? null;
    }

    public function getCode()
    {
        return $this->data['vads_result'] ?? null;
    }

    public function getUuid()
    {
        return $this->data['vads_trans_uuid'] ?? null;
    }
}
