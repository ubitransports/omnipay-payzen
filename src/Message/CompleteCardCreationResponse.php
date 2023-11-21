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

    public function isSuccessful(): bool
    {
        return $this->getTransactionStatus() == 'ACCEPTED';
    }

    public function getTransactionReference(): ?string
    {
        return $this->data['vads_trans_id'] ?? null;
    }

    public function getAmount()
    {
        return $this->data['vads_amount'] ?? null;
    }

    public function getTransactionStatus()
    {
        return $this->data['vads_trans_status'] ?? null;
    }

    public function getUuid()
    {
        return $this->data['vads_trans_uuid'] ?? null;
    }
}
