<?php

namespace Omnipay\PayZen\Message;

interface CardCreationResponseInterface
{
    public function hasCreatedCard(): bool;

    public function getCardReference();

    public function getCardNumber();

    public function getCardExpiryDate(): ?\DateTime;

    public function getCardBrand();

    public function getOwnerReference();

    public function getMetadata(): array;
}
