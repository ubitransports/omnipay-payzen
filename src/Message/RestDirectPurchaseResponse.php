<?php
namespace Omnipay\PayZen\Message;

class RestDirectPurchaseResponse extends RestResponse
{
    /**
     * @inheritdoc
     */
    public function isSuccessful()
    {
        return parent::isSuccessful() && 'SUCCESS' === $this->getData()['status'];
    }

    /**
     * @return string|null
     */
    public function getTransactionUUID()
    {
        if (!$this->isSuccessful()) {
            return null;
        }

        return $this->getData()['answer']['transactions'][0]['uuid'];
    }

    public function getTransactionReference()
    {
        if (!$this->isSuccessful()) {
            return null;
        }
        return $this->getData()['answer']['orderDetails']['orderId'];
    }
}