<?php

namespace modules\main\models\backend;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Class Demo
 *
 * @package modules\main\models\backend
 */
class Demo extends Model
{
    /** @var array */
    private $data = [];

    /**
     * @param array $data
     * @param int $totalPoints
     * @return array
     */
    public function getRandomData($totalPoints = 100, $data = [])
    {
        if (is_null($data)) {
            $data = [];
        }
        if (count($data) > 0) {
            $data = array_slice($data, 1);
        }
        $randomWalk = $this->randomWalk($totalPoints, $data);
        $res = [];
        foreach ($randomWalk as $key => $item) {
            $res[] = [$key, $item];
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
    private function randomWalk($totalPoints = 100, $data = [])
    {
        $count = count($data);
        while ($count < $totalPoints) {
            $prev = $count > 0 ? (int)$data[$count - 1] : 50;
            $val = $prev + self::randomFloat() * 10 - 5;
            if ($val < 0) {
                $val = 0;
            } elseif ($val > $totalPoints) {
                $val = $totalPoints;
            }
            $data[] = $val;
            $count++;
        }
        return $data;
    }

    /**
     * Вычисление случайного числа с плавающей точкой
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
