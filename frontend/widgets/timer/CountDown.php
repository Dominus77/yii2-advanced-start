<?php

namespace frontend\widgets\timer;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use frontend\widgets\timer\assets\CountDownAsset;

/**
 * Class CountDown
 * @package frontend\widgets\timer
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
     * Message note
     * @var string
     */
    public $message = 'Done! Please update this page.';

    /**
     * Plugin options
     * @see https://tutorialzine.com/2011/12/countdown-jquery
     * @var array
     */
    public $clientOptions = [];

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->timestamp *= 1000;
    }

    /**
     * @return string|void
     */
    public function run()
    {
        if ($this->status === true) {
            $this->registerResource();
            echo Html::tag('div', '', ['id' => 'countdown_' . $this->id]) . PHP_EOL;
            echo Html::tag('div', '', ['id' => 'note_' . $this->id, 'class' => 'note']) . PHP_EOL;
        }
    }

    /**
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
        $script = "            
            initCountDownTimer({$options});
        ";
        $view->registerJs($script);
    }
}
