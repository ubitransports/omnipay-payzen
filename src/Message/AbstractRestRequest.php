<?php
namespace Omnipay\Payzen\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

abstract class AbstractRestRequest extends AbstractRequest
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
    public function sendData($data)
    {
        if ($this->getHttpMethod() == 'GET') {
            $httpRequest = $this->httpClient->createRequest(
                $this->getHttpMethod(),
                $this->getEndpoint() . '?' . http_build_query($data),
                array(
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $this->getBearerToken(),
                    'Content-type' => 'application/json',
                )
            );
        } else {
            $httpRequest = $this->httpClient->createRequest(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                array(
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . $this->getBearerToken(),
                    'Content-type' => 'application/json',
                ),
                $this->toJSON($data)
            );
        }

        try {
            $httpResponse = $httpRequest->send();
            $body = $httpResponse->getBody(true);
            $jsonToArrayResponse = !empty($body) ? $httpResponse->json() : [];
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
    public function getUsername()
    {
        return $this->getParameter('username');
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
}
