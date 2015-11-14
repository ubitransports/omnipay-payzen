<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * PayZen Complete Purchase Request
 */
class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $signature = $this->generateSignature($this->httpRequest->request->all());
        if (strtolower($this->httpRequest->request->get('signature')) !== $key) {
            throw new InvalidResponseException('Invalid signature');
        }

        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}

