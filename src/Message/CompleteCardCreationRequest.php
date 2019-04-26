<?php

namespace Omnipay\PayZen\Message;

/**
 * PayZen Complete Card Creation Request
 */
class CompleteCardCreationRequest extends AbstractRequest
{
    use GetValidatedSignedDataTrait;

    public function sendData($data)
    {
        return $this->response = new CompleteCardCreationResponse($this, $data);
    }
}
