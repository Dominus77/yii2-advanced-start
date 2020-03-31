<?php

namespace console\components\helpers;

/**
 * Class Console
 * @package console\components\helpers
 */
class Console extends \yii\helpers\Console
{
    /**
     * Convert string encode to
     *
     * @param array|string $string
     * @param string $code
     * @param string $to
     * @return array|string
     */
    public static function convertEncoding($string, $code = 'UTF-8', $to = 'auto')
    {
        if (is_array($string)) {
            $strings = [];
            foreach ($string as $key => $value) {
                $strings[$key] = mb_convert_encoding($value, $code, $to);
            }
            return $strings;
        }
        return mb_convert_encoding($string, $code, $to);
    }
}
