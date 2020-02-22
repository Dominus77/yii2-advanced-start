<?php

namespace common\components\maintenance\widgets\timer;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use common\components\maintenance\widgets\timer\assets\CountDownAsset;

/**
 * Class CountDown
 * @package common\components\maintenance\widgets\timer
 *
 * @property array $options
 * @property string $html
 */
class CountDown extends Widget
{
    /**
     * Widget on/off
     * @var bool
     */
    public $status = true;

    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        if (isset($this->clientOptions['timestamp']) && !empty($this->clientOptions['timestamp'])) {
            $this->clientOptions['timestamp'] *= 1000;
        }
    }

    /**
     * @return string|void
     */
    public function run()
    {
        if ($this->status === true) {
            $this->registerResource();
            echo Html::tag('div', '', ['id' => $this->id]) . PHP_EOL;
        }
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return ArrayHelper::merge($this->clientOptions, []);
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
            $('#{$this->id}').countdown({$options});
        ";
        $view->registerJs($script);
    }
}
