<?php
namespace Omnipay\PayZen\Message;

use Omnipay\Common\Message\AbstractRequest as OmniPayAbstractRequest;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

abstract class AbstractRestRequest extends OmniPayAbstractRequest
{
    /**
     * Rest API endpoint
     * @var string
     */
    protected $liveEndPoint = "https://api.payzen.eu";

    /**
     * Send data to payzen Rest API as a GET or a POST
     * it depends on the need of the request
     * @param array $data
     * @throws InvalidResponseException
     * @return ResponseInterface
     */
    public function sendData($data): ResponseInterface
    {
        try {
            if ($this->getHttpMethod() == 'GET') {
                $requestUrl = $this->getEndpoint() . '?' . http_build_query($data);
                $body = null;
            } else {
                $body = $this->toJSON($data);
                $requestUrl = $this->getEndpoint();
            }

            $httpResponse = $this->httpClient->request(
                $this->getHttpMethod(),
                $requestUrl,
                array(
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $this->getBearerToken(),
                    'Content-type' => 'application/json',
                ),
                $body
            );

            $body = (string) $httpResponse->getBody()->getContents();
            $jsonToArrayResponse = !empty($body) ? json_decode($body, true) : array();
            return $this->response = $this->createResponse($jsonToArrayResponse, $httpResponse->getStatusCode());
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    /**
     * @return string
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * @return string
     */
    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    /**
     * @return string
     */
    public function setTestPassword($value)
    {
        return $this->setParameter('testPassword', $value);
    }

    /**
     * @return string
     */
    public function getTestPassword()
    {
        return $this->getParameter('testPassword');
    }

    /**
     * Use to define the request verb
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->liveEndPoint;
    }

    /**
     * Convert a set of data into a JSON
     * @param array $data
     * @param integer $options
     * @return string
     */
    protected function toJSON(array $data, $options = 0)
    {
        return json_encode($data, $options | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Allow the use of custom Response
     * @param array $data
     * @param integer $statusCode
     */
    abstract protected function createResponse($data, $statusCode);

    /**
     * Make the Authorization token for PayZen Rest API
     * @return string
     */
    private function getBearerToken()
    {
        $username = $this->getUsername();
        $password = $this->getPassword();
        if ($this->getTestMode()) {
            $password = $this->getTestPassword();
        }

        return base64_encode(sprintf(
            '%s:%s',
            $username,
            $password
        ));
    }

    /**
     * @param string
     * @return boolean
     */
    public function hasParameter($key)
    {
        return $this->parameters->has($key);
    }

    /**
     * @return boolean
     */
    public function getWithForm()
    {
        return $this->getParameter('withForm');
    }

    /**
     * @param boolean
     * @return self
     */
    public function setWithForm($value)
    {
        return $this->setParameter('withForm', $value);
    }
}
