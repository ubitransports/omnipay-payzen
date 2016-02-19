<?php

namespace Omnipay\PayZen\Message;

/**
 * PayZen Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{

    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }

    public function getTransactionDate()
    {
        return $this->getParameter('transactionDate');
    }

    public function setTransactionDate($value)
    {
        return $this->setParameter('transactionDate', $value);
    }

    public function getCertificate()
    {
        return $this->getParameter('certificate');
    }

    public function setCertificate($value)
    {
        return $this->setParameter('certificate', $value);
    }

    public function setSuccessUrl($value)
    {
        return $this->setParameter('successUrl', $value);
    }

    public function getSuccessUrl()
    {
        return $this->getParameter('successUrl');
    }

    public function setCancelUrl($value)
    {
        return $this->setParameter('cancelUrl', $value);
    }

    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }

    public function setErrorUrl($value)
    {
        return $this->setParameter('errorUrl', $value);
    }

    public function getErrorUrl()
    {
        return $this->getParameter('errorUrl');
    }

    public function setRefusedUrl($value)
    {
        return $this->setParameter('refusedUrl', $value);
    }

    public function getRefusedUrl()
    {
        return $this->getParameter('refusedUrl');
    }

    public function setPaymentCards($value)
    {
        $this->setParameter('paymentCards', $value);
    }

    public function getPaymentCards()
    {
        return $this->getParameter('paymentCards');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    public function setUuid($value)
    {
        return $this->setParameter('vads_trans_uuid', $value);
    }

    public function getUuid()
    {
        return $this->setParameter('vads_trans_uuid');
    }

    public function formatCurrency($amount)
    {
        return strval(intval($amount * 100));
    }

    public function addParameter($key, $value)
    {
        return $this->parameters->set($key, $value);
    }

    /**
     * @see https://payzen.eu/wp-content/uploads/2013/04/Guide_d_implementation_formulaire_paiement_PayZen_v3.4.pdf
     */
    protected function generateSignature($data)
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
