<?php
/**
 * @desc helper.php
 * @auhtor Wayne
 * @time 2023/11/22 17:03
 */
namespace dasher\spider;

class Helper{

    /**
     * @throws \Exception
     */
    public static function convertToIST($date, $format = 'Y-m-d H:i:s', $from='America/New_York', $to='Asia/Kolkata'): string
    {
        $dateTime = new \DateTime($date, new \DateTimeZone($from));
        $dateTime->setTimezone(new \DateTimeZone($to));
        return $dateTime->format($format);
    }

    /**
     * @throws \Exception
     */
    public static function dateFormat($timestamp,$format = 'Y-m-d H:i:s', $timeZone='America/New_York'): string
    {
        $date = new \DateTime('@' .$timestamp);
        $tz = new \DateTimeZone($timeZone);
        $date->setTimezone($tz);
        return $date->format($format);
    }
}