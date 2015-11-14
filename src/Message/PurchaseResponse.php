<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * PayZen Purchase Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->getEndpoint();
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}
