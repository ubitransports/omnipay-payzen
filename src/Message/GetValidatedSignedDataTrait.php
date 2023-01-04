<?php

namespace Omnipay\Payzen\Message;

use Omnipay\Common\Exception\InvalidResponseException;

trait GetValidatedSignedDataTrait
{
    public function getData()
    {
        $signature = $this->generateSignature($this->httpRequest->request->all());
        $httpRequestSignature = $this->httpRequest->request->get('signature');

        if (!$httpRequestSignature || (strtolower($httpRequestSignature) !== $signature)) {
            throw new InvalidResponseException('Invalid signature');
        }

        return $this->httpRequest->request->all();
    }
}
