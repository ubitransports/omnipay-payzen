<?php
namespace Omnipay\PayZen;

use Omnipay\Common\AbstractGateway;

/**
 * PayZen Gateway
 *
 * @author Aurélien Schelcher <a.schelcher@ubitransports.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'PayZen';
    }

    public function getDefaultParameters()
    {
        return array(
            'certificate' => '',
            'testMode' => false,
        );
    }

    public function getCertificate()
    {
        return $this->getParameter('certificate');
    }

    public function setCertificate($value)
    {
        return $this->setParameter('certificate', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayZen\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PayZen\Message\CompletePurchaseRequest', $parameters);
    }
}
