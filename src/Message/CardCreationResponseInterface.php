<?php

namespace Omnipay\PayZen\Message;

interface CardCreationResponseInterface
{
    public function hasCreatedCard(): bool;

    public function getCardReference(): ?string;

    public function getCardNumber(): ?string;

    public function getCardExpiryDate(): ?\DateTime;

    public function getCardBrand(): ?string;

    public function getOwnerReference(): ?string;

    public function getMetadata(): array;
}
