<?php

namespace Omnipay\PayZen;

use DateTime;

class Validation
{
    public static function isDate(string $date, ?string $format = 'Y-m-d H:i:s'): bool
    {;
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function isDateInPeriod(string $date, string $start, string $end): bool
    {
        $date = strtotime($date);
        return strtotime($start) <= $date && $date <= strtotime($end);
    }
}
