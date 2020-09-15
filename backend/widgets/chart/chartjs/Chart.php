<?php

namespace backend\widgets\chart\chartjs;

use backend\widgets\chart\chartjs\assets\ChartJsAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget;

/**
 * Class Chart
 *
 * @package backend\widgets\chart\chartjs
 */
class Chart extends Widget
{
    const TYPE_LINE = 'line';
    const TYPE_BAR = 'bar';
    const TYPE_RADAR = 'radar';
    const TYPE_PIE = 'pie';
    const TYPE_DOUGHNUT = 'doughnut';
    const TYPE_POLAR_AREA = 'polarArea';
    const TYPE_BUBBLE = 'bubble';
    const TYPE_SCATTER = 'scatter';

    /** @var bool */
    public $status = true;
    /** @var array */
    public $containerOptions = [];
    /** @var array */
    public $clientOptions = [];
    /** @var array */
    public $clientData = [];
    /** @var string */
    public $type;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        if ($this->status === true) {
            $this->registerAsset();
        }
        $this->id = $this->id ?: $this->getId();
        $this->type = $this->type ?: self::TYPE_LINE;
        ArrayHelper::setValue($this->containerOptions, 'id', $this->id);
    }

    /**
     * Run
     *
     * @return string
     */
    public function run()
    {
        return Html::tag('canvas', '', $this->containerOptions);
    }

    /**
     * Client Options
     *
     * @return array
     */
    public function getClientOptions()
    {
        $clientOptions = [];
        return ArrayHelper::merge($clientOptions, $this->clientOptions);
    }

    /**
     * Client Data
     *
     * @return array
     */
    public function getClientData()
    {
        $clientData = [];
        return ArrayHelper::merge($clientData, $this->clientData);
    }

    /**
     * Register Asset
     */
    public function registerAsset()
    {
        $view = $this->getView();
        ChartJsAsset::register($view);
        $clientData = Json::encode($this->getClientData());
        $clientOptions = Json::encode($this->getClientOptions());
        $type = $this->type;
        $script = "
            let ctx_{$this->id} = document.getElementById('{$this->id}').getContext('2d');
            let jsChart_{$this->id} = new Chart(ctx_{$this->id}, {
                type: '{$type}',
                data: {$clientData},
                options: {$clientOptions}
            });
         ";
        $view->registerJs($script);
    }
}
