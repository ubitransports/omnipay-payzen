<?php
namespace Omnipay\PayZen;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

/**
 * PayZen Rest Gateway
 *
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'PayZen Rest';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'username' => '',
            'password' => '',
            'testMode' => false,
        ];
    }

    /**
     * @param array $parameters
     * @return RequestInterface
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Payzen\Message\RestPurchaseRequest', $parameters);
    }

    /**
     * @param string
     */
    public function setUsername($value)
    {
        $this->setParameter('username', $value);
    }

    /**
     * @param string
     */
    public function setTestUsername($value)
    {
        $this->setParameter('testUsername', $value);
    }

    /**
     * @param string
     */
    public function setPassword($value)
    {
        $this->setParameter('password', $value);
    }

    /**
     * @param string
     */
    public function setTestPassword($value)
    {
        $this->setParameter('testPassword', $value);
    }
}
