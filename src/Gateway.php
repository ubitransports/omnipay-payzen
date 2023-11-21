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
    public function getName(): string
    {
        return 'PayZen';
    }

    public function getDefaultParameters(): array
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

    public function setCertificate($value): Gateway
    {
        return $this->setParameter('certificate', $value);
    }

    public function purchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\PayZen\Message\PurchaseRequest', $options);
    }

    public function completePurchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\PayZen\Message\CompletePurchaseRequest', $options);
    }

    public function createCard(array $options = array())
    {
        return $this->createRequest('\Omnipay\PayZen\Message\CreateCardRequest', $options);
    }

    public function completeCardCreation(array $options = array())
    {
        return $this->createRequest('\Omnipay\PayZen\Message\CompleteCardCreationRequest', $options);
    }
}
