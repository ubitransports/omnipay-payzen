<?php
namespace Omnipay\PayZen\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class RestPurchaseRequest extends AbstractRestRequest
{
    /**
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('amount', 'currency');

        $data = [
            'amount' => $this->getAmountInteger(),
            'currency' => $this->getCurrency(),
            'orderId' => $this->getTransactionId(),
        ];

        if ($this->getCard()) {
            $data['customer'] = [
                'email' => $this->getCard()->getEmail(),
                'billingDetails' => [
                    'firstName' => $this->getCard()->getBillingFirstName(),
                    'lastName' => $this->getCard()->getBillingLastName(),
                    'address' => $this->getCard()->getBillingAddress1(),
                    'address2' => $this->getCard()->getBillingAddress2(),
                    'city' => $this->getCard()->getBillingCity(),
                    'state' => $this->getCard()->getBillingState(),
                    'zipCode' => $this->getCard()->getBillingPostcode(),
                    'country' => $this->getCard()->getBillingCountry(),
                    'phoneNumber' => $this->getCard()->getBillingPhone(),
                ]
            ];
        }

        if ($this->getCardReference()) {
            $data['paymentMethodToken'] = $this->getCardReference();
        }

        if ($this->getFormType()) {
            $data['formAction'] = $this->getFormType();
        }

        return $data;
    }

    public function getFormType(): string
    {
        if (!$this->hasParameter('withForm') || $this->getWithForm()) {
            return 'PAYMENT';
        }

        return 'SILENT';
    }

    public function getCardReference(): ?string
    {
        return $this->getParameter('cardReference');
    }

    /**
     * Endpoint for this request
     * @return string
     */
    protected function getEndpoint(): string
    {
        return parent::getEndpoint() . '/api-payment/V4/Charge/CreatePayment';
    }

    /**
     * @inheritdoc
     */
    protected function createResponse($data, $statusCode)
    {
        if (!$this->getWithForm()) {
            return $this->response = new RestDirectPurchaseResponse($this, $data, $statusCode);
        }

        return $this->response = new RestResponse($this, $data, $statusCode);
    }
}
