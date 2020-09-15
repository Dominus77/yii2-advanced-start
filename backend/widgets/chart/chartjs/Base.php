<?php

namespace backend\widgets\chart\chartjs;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use backend\widgets\chart\chartjs\assets\ChartJsAsset;

/**
 * Class Base
 *
 * @package backend\widgets\chart\chartjs
 */
abstract class Base extends Widget
{
    /** @var bool */
    public $status = true;
    /** @var array */
    public $containerOptions = [];
    /** @var array */
    public $clientOptions = [];
    /** @var array */
    public $clientData = [];

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
        $containerOptions = [];
        ArrayHelper::setValue($containerOptions, 'id', $this->id);
        $this->containerOptions = ArrayHelper::merge($containerOptions, $this->containerOptions);
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
        return [];
    }

    /**
     * Client Data
     *
     * @return array
     */
    public function getClientData()
    {
        return [];
    }

    /**
     * Register Asset
     */
    public function registerAsset()
    {
        $view = $this->getView();
        ChartJsAsset::register($view);
    }
}
