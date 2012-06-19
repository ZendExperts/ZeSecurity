<?php
namespace ZeSecurity\IDS\Util;

class FormatNumbers
{
    public static function addOrdinalNumberSuffix($num)
    {
        $ord = ($num % 100);
        if ( !($ord== 11 || $ord==12 || $ord==13) ) {
            switch ($ord % 10) {
                // Handle 1st, 2nd, 3rd
                case 1:
                    return $num . 'st';
                case 2:
                    return $num . 'nd';
                case 3:
                    return $num . 'rd';
            }
        }
        return $num . 'th';
    }
}