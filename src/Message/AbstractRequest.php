<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Common\Message\AbstractRequest as OmniPayAbstractRequest;

/**
 * PayZen Abstract Request
 */
abstract class AbstractRequest extends OmniPayAbstractRequest
{

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value): AbstractRequest
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getTransactionDate()
    {
        return $this->getParameter('transactionDate');
    }

    public function setTransactionDate($value): AbstractRequest
    {
        return $this->setParameter('transactionDate', $value);
    }

    public function getCertificate()
    {
        return $this->getParameter('certificate');
    }

    public function setCertificate($value): AbstractRequest
    {
        return $this->setParameter('certificate', $value);
    }

    public function setSuccessUrl($value): AbstractRequest
    {
        return $this->setParameter('successUrl', $value);
    }

    public function getSuccessUrl()
    {
        return $this->getParameter('successUrl');
    }

    public function setRedirectSuccessTimeout($value): AbstractRequest
    {
        return $this->setParameter('redirectSuccessTimeout', $value);
    }

    public function getRedirectSuccessTimeout()
    {
        return $this->getParameter('redirectSuccessTimeout');
    }

    public function setCancelUrl($value): AbstractRequest
    {
        return $this->setParameter('cancelUrl', $value);
    }

    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }

    public function setErrorUrl($value): AbstractRequest
    {
        return $this->setParameter('errorUrl', $value);
    }

    public function getErrorUrl()
    {
        return $this->getParameter('errorUrl');
    }

    public function setRedirectErrorTimeout($value): AbstractRequest
    {
        return $this->setParameter('redirectErrorTimeout', $value);
    }

    public function getRedirectErrorTimeout()
    {
        return $this->getParameter('redirectErrorTimeout');
    }

    public function setRefusedUrl($value): AbstractRequest
    {
        return $this->setParameter('refusedUrl', $value);
    }

    public function getRefusedUrl()
    {
        return $this->getParameter('refusedUrl');
    }

    public function setPaymentCards($value): AbstractRequest
    {
        $this->setParameter('paymentCards', $value);
    }

    public function getPaymentCards()
    {
        return $this->getParameter('paymentCards');
    }

    public function setOrderId($value): AbstractRequest
    {
        return $this->setParameter('orderId', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setUuid($value): AbstractRequest
    {
        return $this->setParameter('vads_trans_uuid', $value);
    }

    public function getUuid()
    {
        return $this->getParameter('vads_trans_uuid');
    }

    public function setOwnerReference($value): AbstractRequest
    {
        return $this->setParameter('ownerReference', $value);
    }

    public function getOwnerReference()
    {
        return $this->getParameter('ownerReference');
    }

    public function setMetadata(array $value): AbstractRequest
    {
        return $this->setParameter('metadata', $value);
    }

    public function getMetadata()
    {
        return $this->getParameter('metadata');
    }

    public function formatCurrency($amount): string
    {
        return (string) intval(strval($amount * 100));
    }

    public function addParameter($key, $value): AbstractRequest
    {
        return $this->setParameter($key, $value);
    }

    /**
     * @see https://payzen.eu/wp-content/uploads/2013/04/Guide_d_implementation_formulaire_paiement_PayZen_v3.4.pdf
     */
    protected function generateSignature($data): string
    {
        // Sort the data
        ksort($data);

        // Filter only the vads_* fields
        $matchedKeys = array_filter(array_keys($data), function ($v) {
            return strpos($v, 'vads_') === 0;
        });
        $data = array_intersect_key($data, array_flip($matchedKeys));

        // Add the certificate
        $data[] = $this->getCertificate();

        return sha1(implode('+', $data));
    }
}
