<?php

namespace Omnipay\PayZen\Message;

use Omnipay\Tests\TestCase;
use Omnipay\Common\Exception\InvalidResponseException;

class CompleteCardCreationRequestTest extends TestCase
{
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new CompleteCardCreationRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * @expectedException Omnipay\Common\Exception\InvalidResponseException
     */
    public function testGetDataWithCorruptedData_ShouldThrowAnException()
    {
        $data = $this->request->getData();
    }
}
