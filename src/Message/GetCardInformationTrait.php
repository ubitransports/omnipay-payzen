<?php

namespace Omnipay\PayZen\Message;

trait GetCardInformationTrait
{
    public function hasCreatedCard(): bool
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
        return $this->data['vads_identifier'] ?? null;
    }

    public function getCardNumber()
    {
        return $this->data['vads_card_number'] ?? null;
    }

    public function getCardExpiryDate(): ?\DateTime
    {
        if (!isset($this->data['vads_expiry_year'])
            || !isset($this->data['vads_expiry_month'])
        ) {
            return null;
        }

        $beginningOfMonth = new \DateTime(
            sprintf('%s-%s', $this->data['vads_expiry_year'], $this->data['vads_expiry_month'])
        );

        return $beginningOfMonth->modify('last day of this month');
    }

    public function getCardBrand()
    {
        return $this->data['vads_card_brand'] ?? null;
    }

    public function getOwnerReference()
    {
        return $this->data['vads_ext_info_owner_reference'] ?? null
        ;
    }
}
