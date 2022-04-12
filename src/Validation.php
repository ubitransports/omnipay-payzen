<?php

namespace Omnipay\PayZen;

use DateTime;

class Validation
{
    /**
     * @param string $date
     * @param string $format
     * @return bool
     */
    public static function isDate($date, $format = 'Y-m-d H:i:s')
    {;
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * @param string $date
     * @param string $start
     * @param string $end
     * @return bool
     */
    public static function isDateInPeriod($date, $start, $end)
    {
        $date = strtotime($date);
        return strtotime($start) <= $date && $date <= strtotime($end);
    }
}
