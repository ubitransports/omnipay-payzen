<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class RedirectToGatewayResponse extends AbstractResponse implements RedirectResponseInterface
{
    public string $liveEndpoint = 'https://secure.payzen.eu/vads-payment/';

    public function getEndpoint(): string
    {
        return $this->liveEndpoint;
    }

    public function isSuccessful(): bool
    {
        return false;
    }

    public function isRedirect(): bool
    {
        return true;
    }

    public function getRedirectUrl(): string
    {
        return $this->getEndpoint();
    }

    public function getRedirectMethod(): string
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}
