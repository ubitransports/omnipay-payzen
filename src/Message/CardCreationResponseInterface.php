<?php

namespace Omnipay\PayZen\Message;

interface CardCreationResponseInterface
{
    /**
     * @return bool
     */
    public function hasCreatedCard();

    /**
     * @return string|null
     */
    public function getCardReference();

    /**
     * @return string|null
     */
    public function getCardNumber();

    /**
     * @return \DateTime|null
     */
    public function getCardExpiryDate();

    /**
     * @return string|null
     */
    public function getCardBrand();
}
