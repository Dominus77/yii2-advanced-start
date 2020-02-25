<?php

namespace common\components\maintenance\models;

use Yii;
use yii\base\Model;
use common\components\maintenance\StateInterface;
use Exception;

/**
 * Class Manager
 * @package common\components\maintenance\models
 *
 * @property mixed $followers
 * @property mixed $datetime
 * @property int $timestamp
 */
class Manager extends Model
{
    /**
     * @var string
     */
    public $date;

    /**
     * @var StateInterface
     */
    protected $state;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->state = Yii::$container->get(StateInterface::class);
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function rules()
    {
        return [
            ['date', 'trim'],
            ['date', 'required'],
            ['date', 'string', 'max' => 19],
        ];
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'date' => Yii::t('app', 'Date and Time'),
        ];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getDatetime()
    {
        return $this->state->datetime($this->getTimestamp(), $this->state->dateFormat);
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getTimestamp()
    {
        return $this->state->timestamp();
    }

    /**
     * @return mixed
     */
    public function getFollowers()
    {
        return $this->state->emails();
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->state->isEnabled();
    }
}
