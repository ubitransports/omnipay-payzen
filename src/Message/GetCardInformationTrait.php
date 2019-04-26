<?php

namespace Omnipay\PayZen\Message;

trait GetCardInformationTrait
{
    /**
     * @inheritDoc
     */
    public function hasCreatedCard()
    {
        if (isset($this->data['vads_identifier_status'])
            && 'CREATED' ===  $this->data['vads_identifier_status']
        ) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getCardReference()
    {
        return isset($this->data['vads_identifier']) ? $this->data['vads_identifier'] : null;
    }

    /**
     * @inheritDoc
     */
    public function getCardNumber()
    {
        return isset($this->data['vads_card_number']) ? $this->data['vads_card_number'] : null;
    }

    /**
     * @inheritDoc
     */
    public function getCardExpiryDate()
    {
        if (!isset($this->data['vads_expiry_year'])
            || !isset($this->data['vads_expiry_month'])
        ) {
            return null;
        }

        return new \DateTime(
            sprintf('%s-%s', $this->data['vads_expiry_year'], $this->data['vads_expiry_month'])
        );
    }

    /**
     * @inheritDoc
     */
    public function getCardBrand()
    {
        return isset($this->data['vads_card_brand']) ? $this->data['vads_card_brand'] : null;
    }
}
