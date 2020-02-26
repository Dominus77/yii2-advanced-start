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
    const MODE_MAINTENANCE_ON = 'maintenanceOn';
    const MODE_MAINTENANCE_OFF = 'maintenanceOff';

    /**
     * Select mode
     * @var array
     */
    public $mode;
    /**
     * Datetime
     * @var string
     */
    public $date;
    /**
     * Title
     * @var string
     */
    public $name;
    /**
     * Text
     * @var string
     */
    public $text;
    /**
     * Subscribe
     * @var bool
     */
    public $subscribe = true;
    /**
     * CountDown
     * @var bool
     */
    public $countDown = true;

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
        $this->name = $this->name ?: Yii::t('app', 'Maintenance');
        $this->text = $this->text ?: Yii::t('app', 'The site is undergoing technical work. We apologize for any inconvenience caused.');
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function rules()
    {
        return [
            ['date', 'trim'],
            [['date', 'mode'], 'required'],
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
            'mode' => Yii::t('app', 'Mode'),
            'date' => Yii::t('app', 'Date and Time'),
            'name' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'subscribe' => Yii::t('app', 'Subscribe'),
            'countDown' => Yii::t('app', 'Count Down'),
        ];
    }

    /**
     * Modes
     * @return array
     */
    public static function getModesArray()
    {
        return [
            self::MODE_MAINTENANCE_OFF => Yii::t('app', 'Mode normal'),
            self::MODE_MAINTENANCE_ON => Yii::t('app', 'Mode maintenance'),
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
