<?php

namespace api\components;

use Yii;
use yii\base\Action;
use yii\filters\RateLimitInterface;
use yii\web\Request;

/**
 * Class IpLimiter
 * @package api\components
 */
class IpLimiter implements RateLimitInterface
{
    /**
     * Разрешенное количество запросов
     */
    const RATE_LIMIT = 10;

    /**
     * Время в секундах
     */
    const RATE_LIMIT_TIME = 60;

    /**
     * @var string
     */
    public $allowance;

    /**
     * @var string
     */
    public $allowance_updated_at;

    /**
     * @var string
     */
    private $cache_key = 'limitRelate';

    /**
     * @param Request $request
     * @param Action $action
     * @return array
     */
    public function getRateLimit($request, $action)
    {
        return [self::RATE_LIMIT, self::RATE_LIMIT_TIME];
    }

    /**
     * @param Request $request
     * @param Action $action
     * @return array
     */
    public function loadAllowance($request, $action)
    {
        $cache = Yii::$app->cache;
        $data = $cache->get($this->cache_key);
        if ($data = unserialize($data)) {
            return [$data['allowance'], $data['allowance_updated_at']];
        }
        return [$this->allowance, $this->allowance_updated_at];
    }

    /**
     * @param Request $request
     * @param Action $action
     * @param int $allowance
     * @param int $timestamp
     */
    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        $array = [
            'allowance' => $allowance,
            'allowance_updated_at' => $timestamp,
        ];
        $cache = Yii::$app->cache;
        if ($cache->get($this->cache_key)) {
            $cache->delete($this->cache_key);
        }
        $cache->add($this->cache_key, serialize($array), self::RATE_LIMIT_TIME);
    }
}
