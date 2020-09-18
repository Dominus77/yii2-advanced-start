<?php

namespace backend\widgets\chart\flot\data;

/**
 * Class Demo
 *
 * @package modules\main\models\backend
 */
class Demo
{
    /**
     * Demo Random Data
     *
     * @param array $data
     * @param int $totalPoints
     * @return array
     */
    public static function getRandomData($data = [], $totalPoints = 100)
    {
        if (is_null($data)) {
            $data = [];
        }
        if (count($data) > 0) {
            $data = array_slice($data, 1);
        }
        $randomWalk = self::randomWalk($totalPoints, $data);
        // Zip the generated y values with the x values
        $res = [];
        foreach ($randomWalk as $key => $items) {
            $items[0] = $key;
            $res[] = $items;
        }
        return $res;
    }

    /**
     * Do a random walk
     *
     * @param array $data
     * @param int $totalPoints
     * @return array
     */
    public static function randomWalk($totalPoints = 100, $data = [])
    {
        $count = count($data);
        while ($count < $totalPoints) {
            $prev = $count > 0 ? (int)$data[$count - 1] : $totalPoints / 2;
            $val = $prev + self::randomFloat(0, $totalPoints);
            if ($val < 0) {
                $val = 0;
            } elseif ($val > $totalPoints) {
                $val = $totalPoints;
            }
            $data[] = [$count, $val];
            $count++;
        }
        return $data;
    }

    /**
     * Calculating a random floating point number
     *
     * @param int $min
     * @param int $max
     * @return float|int|mixed
     */
    public static function randomFloat($min = 0, $max = 1)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}
