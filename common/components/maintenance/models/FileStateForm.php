<?php

namespace common\components\maintenance\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use common\components\maintenance\interfaces\StateInterface;
use common\components\maintenance\states\FileState;
use Exception;

/**
 * Class FileStateForm
 * @package common\components\maintenance\models
 *
 * @property mixed $followers
 * @property mixed $datetime
 * @property mixed $modeName
 * @property string $dateFormat
 * @property int $timestamp
 */
class FileStateForm extends Model
{
    const MODE_MAINTENANCE_ON = 'On';
    const MODE_MAINTENANCE_OFF = 'Off';

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
    public $title;
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
     * @var array
     */
    private $followers;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->state = Yii::$container->get(StateInterface::class);
        $this->mode = self::MODE_MAINTENANCE_OFF;
        $this->date = $this->datetime;
        $this->title = $this->title ?: Yii::t('app', $this->state->defaultTitle);
        $this->text = $this->text ?: Yii::t('app', $this->state->defaultContent);
        $this->setFollowers();
        $this->setData();
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function rules()
    {
        return [
            ['date', 'trim'],
            ['mode', 'required'],
            ['date', 'string', 'max' => 19],
            ['date', 'validateDateAttribute'],
            [['title', 'text'], 'string'],
            [['subscribe', 'countDown'], 'boolean']
        ];
    }

    /**
     * @param $attribute
     * @throws InvalidConfigException
     */
    public function validateDateAttribute($attribute)
    {
        if ($attribute && !$this->state->validDate($this->$attribute)) {
            $example = Yii::$app->formatter->asDatetime(time(), 'php:' . $this->state->dateFormat);
            $this->addError($attribute, Yii::t('app', 'Invalid date format. Use example: {:example}', [':example' => $example]));
        }
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
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'subscribe' => Yii::t('app', 'Subscribe'),
            'countDown' => Yii::t('app', 'Count Down'),
        ];
    }

    /**
     * Mode name
     * @return mixed
     */
    public function getModeName()
    {
        return ArrayHelper::getValue(self::getModesArray(), $this->mode);
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
     * Save this in file
     */
    public function save()
    {
        $result = false;
        if ($this->mode === self::MODE_MAINTENANCE_ON) {
            if ($this->isEnabled()) {
                $this->update();
                Yii::$app->session->setFlash('success', 'Технический режим успешно обновлен!');
                $result = true;
            } else {
                $this->enable();
                $result = true;
            }
        }
        if ($this->mode === self::MODE_MAINTENANCE_OFF) {
            $this->disable();
            $result = true;
        }
        return $result;
    }

    /**
     * Enable
     * @return mixed
     */
    public function enable()
    {
        $subscribe = $this->subscribe ? FileState::MAINTENANCE_SUBSCRIBE_ON : FileState::MAINTENANCE_SUBSCRIBE_OFF;
        return $this->state->enable($this->date, $this->title, $this->text, $subscribe);
    }

    /**
     * Update
     * @return array
     */
    public function update()
    {
        $result = [];
        foreach ($this->attributes as $key => $value) {
            if ($key === FileState::MAINTENANCE_PARAM_SUBSCRIBE) {
                $value = $value ? FileState::MAINTENANCE_SUBSCRIBE_ON : FileState::MAINTENANCE_SUBSCRIBE_OFF;
            }
            $result[$key] = $this->state->update($key, $value);
        }
        return $result;
    }

    /**
     * Disable
     * @return int|mixed
     */
    public function disable()
    {
        return $this->state->disable();
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
     * @return array
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * @param array $followers
     */
    public function setFollowers($followers = [])
    {
        $this->followers = $followers ?: $this->state->emails();
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->state->isEnabled();
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->state->dateFormat;
    }

    /**
     * Set data is enabled
     */
    private function setData()
    {
        if ($this->isEnabled()) {
            $this->mode = self::MODE_MAINTENANCE_ON;
            $this->date = $this->datetime;
            $this->title = $this->state->getParams(FileState::MAINTENANCE_PARAM_TITLE);
            $this->text = $this->state->getParams(FileState::MAINTENANCE_PARAM_CONTENT);
            $subscribe = $this->state->getParams(FileState::MAINTENANCE_PARAM_SUBSCRIBE);
            $this->subscribe = ($subscribe === FileState::MAINTENANCE_SUBSCRIBE_ON);
            $this->countDown = true;
        }
    }
}
