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
                    'Authorization' => 'Bearer ' . $this->getBearerToken(),
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

    public function setUsername($value): AbstractRestRequest
    {
        return $this->setParameter('username', $value);
    }

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setPassword($value): AbstractRestRequest
    {
        return $this->setParameter('password', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setTestPassword($value): AbstractRestRequest
    {
        return $this->setParameter('testPassword', $value);
    }

    public function getTestPassword()
    {
        return $this->getParameter('testPassword');
    }

    protected function getHttpMethod(): string
    {
        return 'POST';
    }

    protected function getEndpoint(): string
    {
        return $this->liveEndPoint;
    }

    /**
     * Convert a set of data into a JSON
     */
    protected function toJSON(array $data, ?int $options = 0): string
    {
        return json_encode($data, $options | JSON_UNESCAPED_SLASHES);
    }

    abstract protected function createResponse(array $data, int $statusCode);

    /**
     * Make the Authorization token for PayZen Rest API
     */
    private function getBearerToken(): string
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

    public function hasParameter(string $key): bool
    {
        return $this->parameters->has($key);
    }

    public function getWithForm(): bool
    {
        return $this->getParameter('withForm');
    }

    public function setWithForm(bool $value): AbstractRestRequest
    {
        return $this->setParameter('withForm', $value);
    }
}
