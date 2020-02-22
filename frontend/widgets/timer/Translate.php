<?php

namespace frontend\widgets\timer;

/**
 * Class Translate
 * @see https://i18njs.com/
 * @package frontend\widgets\timer
 */
class Translate
{
    const LOCALE_EN = 'en';
    const LOCALE_RU = 'ru';

    /**
     * Switch Locale
     * @param string $locale
     * @return array
     */
    public static function messages($locale)
    {
        switch ($locale) {
            case self::LOCALE_EN:
                $data = self::en();
                break;
            case self::LOCALE_RU:
                $data = self::ru();
                break;
            default:
                $data = self::en();
        }
        return $data;
    }

    /**
     * Locale en
     * @return array
     */
    protected static function en()
    {
        $n = '%n ';
        return [
            'values' => [
                'and' => 'and',
                $n . 'days' => [
                    [0, 0, $n . 'days'],
                    [1, 1, $n . 'day'],
                    [2, null, $n . 'days']
                ],
                $n . 'hours' => [
                    [0, 0, $n . 'hours'],
                    [1, 1, $n . 'hour'],
                    [2, null, $n . 'hours']
                ],
                $n . 'minutes' => [
                    [0, 0, $n . 'minutes'],
                    [1, 1, $n . 'minute'],
                    [2, null, $n . 'minutes']
                ],
                $n . 'seconds' => [
                    [0, 0, $n . 'seconds'],
                    [1, 1, $n . 'second'],
                    [2, null, $n . 'seconds']
                ]
            ]
        ];
    }

    /**
     * Locale ru
     * @return array
     */
    protected static function ru()
    {
        $n = '%n ';
        $values = [
            $n . 'days' => [
                0 => $n . 'дней',
                1 => $n . 'день',
                2 => $n . 'дня',
            ],
            $n . 'hours' => [
                0 => $n . 'часов',
                1 => $n . 'час',
                2 => $n . 'часа',
            ],
            $n . 'minutes' => [
                0 => $n . 'минут',
                1 => $n . 'минута',
                2 => $n . 'минуты',
            ],
            $n . 'seconds' => [
                0 => $n . 'секунд',
                1 => $n . 'секунда',
                2 => $n . 'секунды',
            ]
        ];

        $result = [
            'values' => [
                'and' => 'и'
            ]
        ];

        foreach ($values as $key => $value) {
            foreach ($value as $count => $item) {
                $result['values'][$key] = [
                    [0, 0, $values[$key][0]],
                    [1, 1, $values[$key][1]],
                    [5, 20, $values[$key][0]],
                    [21, 21, $values[$key][1]],
                    [25, 30, $values[$key][0]],
                    [31, 31, $values[$key][1]],
                    [35, 40, $values[$key][0]],
                    [41, 41, $values[$key][1]],
                    [45, 50, $values[$key][0]],
                    [51, 51, $values[$key][1]],
                    [55, 60, $values[$key][0]],
                    [61, 61, $values[$key][1]],
                    [65, 70, $values[$key][0]],
                    [71, 71, $values[$key][1]],
                    [75, 80, $values[$key][0]],
                    [81, 81, $values[$key][1]],
                    [85, 90, $values[$key][0]],
                    [91, 91, $values[$key][1]],
                    [95, 100, $values[$key][0]],
                    [2, null, $values[$key][2]]
                ];
            }
        }
        return $result;
    }
}
