<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 08.10.16
 * Time: 11:15
 */

namespace console\components\helpers;


class Console extends \yii\helpers\Console
{
    /**
     * Convert string encode to
     *
     * @param $string
     * @param string $code
     * @param string $to
     * @return array|string
     */
    public static function convertEncoding($string, $code = 'cp866', $to = 'UTF-8')
    {
        if(is_array($string)) {
            $strings = [];
            foreach($string as $key => $value)
            {
                $strings[$key] = mb_convert_encoding($value, $code, $to);
            }
            return $strings;
        }
        return mb_convert_encoding($string, $code, $to);
    }
}