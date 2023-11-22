<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Common\Exception\InvalidResponseException;

class CompleteCardCreationRequestTest extends TestCase
{
    private CompleteCardCreationRequest $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new CompleteCardCreationRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetDataWithCorruptedData_ShouldThrowAnException()
    {
        $this->expectException(InvalidResponseException::class);
        $data = $this->request->getData();
    }
}
