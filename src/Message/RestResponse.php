<?php
namespace Omnipay\PayZen\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class RestResponse extends AbstractResponse
{
    protected $statusCode;

    public function __construct(RequestInterface $request, array $data, int $statusCode)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    public function isSuccessful(): bool
    {
        return empty($this->data['error']) && $this->getCode() < 400;
    }

    public function getCode(): int
    {
        return $this->statusCode;
    }
}
