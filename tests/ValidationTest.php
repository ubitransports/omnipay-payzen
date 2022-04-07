<?php

namespace Omnipay\PayZen;
use PHPUnit_Framework_TestCase;

class ValidationTest extends PHPUnit_Framework_TestCase
{
    public function testIsDate()
    {
        $this->assertTrue(Validation::isDate('20220101', 'Ymd'));
        $this->assertTrue(Validation::isDate('2022-01-01 10:00:00'));

        $this->assertFalse(Validation::isDate('2022-01-01 10:00:00', 'Ymd'));
        $this->assertFalse(Validation::isDate('20220229', 'Ymd'));
        $this->assertFalse(Validation::isDate('20220229', 'Ymd'));
    }

    public function testIsDateInPeriod()
    {
        $this->assertTrue(Validation::isDateInPeriod('2022-01-01', '2022-01-01', '2022-01-01'));
        $this->assertTrue(Validation::isDateInPeriod('2022-01-01', '2022-01-01', '2022-01-02'));
        $this->assertTrue(Validation::isDateInPeriod('2022-01-01', '2021-12-31', '2022-01-01'));
        $this->assertTrue(Validation::isDateInPeriod('2022-01-01', '2021-12-31', '2022-01-02'));

        $this->assertFalse(Validation::isDateInPeriod('2022-01-01', '2022-01-02', '2022-01-03'));
        $this->assertFalse(Validation::isDateInPeriod('2022-01-01', '2021-12-30', '2021-12-31'));
    }
}
