<?php


namespace App\Factory;


abstract class Helper
{
    static function isJSON($string) {
        return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string, true))))) ? true : false;
    }
}
