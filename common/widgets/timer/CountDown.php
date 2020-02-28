<?php

namespace common\widgets\timer;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\widgets\timer\assets\CountDownAsset;

/**
 * Class CountDown
 * @package common\widgets\timer
 *
 * @property array $options
 */
class CountDown extends Widget
{
    /**
     * Widget on/off
     * @var bool
     */
    public $status = true;

    /**
     * Finish timestamp
     * @var integer
     */
    public $timestamp;

    /**
     * Message complete note
     * @var string
     */
    public $message = '';

    /**
     * Tag options count container
     * @var array
     */
    public $countContainerOptions = [];

    /**
     * Tag options note container
     * @var array
     */
    public $noteContainerOptions = [];

    /**
     * Plugin options
     * @see https://tutorialzine.com/2011/12/countdown-jquery
     * @var array
     */
    public $clientOptions = [];

    /**
     * en/ru
     * @var string
     */
    public $locale;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->timestamp)) {
            $this->status = false;
        }
        $this->timestamp *= 1000;
        $this->locale = $this->locale ?: Yii::$app->language;
        $this->countContainerOptions = ArrayHelper::merge($this->countContainerOptions, ['id' => 'countdown_' . $this->id]);

        $cssClass = ArrayHelper::remove($this->noteContainerOptions, 'class');
        $cssClass = $cssClass ? 'note ' . $cssClass : 'note';
        $this->noteContainerOptions = ArrayHelper::merge($this->noteContainerOptions, ['id' => 'note_' . $this->id, 'class' => $cssClass]);
    }

    /**
     * @inheritDoc
     * @return string|void
     */
    public function run()
    {
        if ($this->status === true) {
            $this->registerResource();
            echo Html::tag('div', '', $this->countContainerOptions) . PHP_EOL;
            echo Html::tag('div', '', $this->noteContainerOptions) . PHP_EOL;
        }
    }

    /**
     * Plugin options
     * @see https://tutorialzine.com/2011/12/countdown-jquery
     * @return array
     */
    protected function getOptions()
    {
        return ArrayHelper::merge($this->clientOptions, [
            'id' => $this->id,
            'timestamp' => $this->timestamp,
            'msg' => $this->message
        ]);
    }

    /**
     * Register resource
     */
    protected function registerResource()
    {
        $view = $this->getView();
        CountDownAsset::register($view);
        $options = Json::encode($this->getOptions());
        $translate = Json::encode(Translate::messages($this->locale));
        $script = "            
            initCountDownTimer({$options}, {$translate});
        ";
        $view->registerJs($script);
    }
}
