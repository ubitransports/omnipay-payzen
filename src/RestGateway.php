<?php
namespace Omnipay\PayZen;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

/**
 * PayZen Rest RestGateway
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class RestGateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'PayZen Rest';
    }

    public function getDefaultParameters(): array
    {
        return [
            'username' => '',
            'password' => '',
            'testPassword' => '',
            'testMode' => true,
        ];
    }

    public function purchase(array $options = []): RequestInterface
    {
        return $this->createRequest('\Omnipay\PayZen\Message\RestPurchaseRequest', $options);
    }

    public function setUsername($value): RestGateway
    {
        return $this->setParameter('username', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setPassword($value): RestGateway
    {
        return $this->setParameter('password', $value);
    }
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setTestPassword($value): RestGateway
    {
        return $this->setParameter('testPassword', $value);
    }

    public function getTestPassword()
    {
        return $this->getParameter('testPassword');
    }
}
