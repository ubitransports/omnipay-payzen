<?php
namespace Omnipay\PayZen\Message;

class RestDirectPurchaseResponse extends RestResponse
{
    public function isSuccessful(): bool
    {
        return parent::isSuccessful() && 'SUCCESS' === $this->getData()['status'] && $this->checkOrderStatus();
    }

    public function getTransactionUUID(): ?string
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

    private function checkOrderStatus(): bool
    {
        $data = $this->getData();
        if (!isset($data['answer'], $data['answer']['orderStatus'])) {
            return false;
        }

        return 'PAID' === $data['answer']['orderStatus'];
    }
}
