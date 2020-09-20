<?php

namespace backend\widgets\chart\sparkline;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use backend\widgets\chart\sparkline\assets\ChartAsset;
use yii\helpers\Json;

/**
 * Class Chart
 *
 * @package backend\widgets\chart\sparkline
 */
class Chart extends Widget
{
    /** @var bool */
    public $status = true;
    /** @var array */
    public $containerOptions = [];
    /** @var array */
    public $clientData = [];
    /** @var array */
    public $clientOptions = [];

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
        ArrayHelper::setValue($this->containerOptions, 'id', $this->id);
    }

    /**
     * Run
     *
     * @return string
     */
    public function run()
    {
        return Html::tag('div', '', $this->containerOptions);
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
     * Register Asset
     */
    public function registerAsset()
    {
        $view = $this->getView();
        ChartAsset::register($view);
        $id = $this->id;
        $clientData = Json::encode($this->getClientData());
        $clientOptions = Json::encode($this->getClientOptions());
        $script = "
            let chart_{$id} = $('#{$id}').sparkline({$clientData}, {$clientOptions});
        ";
        $view->registerJs($script);
    }
}
