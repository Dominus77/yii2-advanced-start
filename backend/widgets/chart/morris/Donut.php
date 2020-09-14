<?php

namespace backend\widgets\chart\morris;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use backend\widgets\chart\morris\assets\MorrisAsset;
use yii\helpers\Json;

/**
 * Class Donut
 *
 * @package backend\widgets\chart\morris
 */
class Donut extends Widget
{
    /** @var bool */
    public $status = true;
    /** @var array */
    public $containerOptions = [];
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
        $containerOptions = [
            'id' => $this->id,
            'style' => 'position: relative; height: 300px;'
        ];
        $this->containerOptions = ArrayHelper::merge($containerOptions, $this->containerOptions);
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
     * Client Options
     *
     * @return array
     */
    public function getClientOptions()
    {
        $clientOptions = [
            'element' => $this->id,
            'resize' => true,
            'colors' => [],
            'hideHover' => 'auto',
            'data' => [],
        ];
        return ArrayHelper::merge($clientOptions, $this->clientOptions);
    }

    /**
     * Register Asset
     */
    public function registerAsset()
    {
        $view = $this->getView();
        MorrisAsset::register($view);
        $clientOptions = Json::encode($this->getClientOptions());
        $script = "
            let morris_donut_{$this->id} = new Morris.Donut({$clientOptions});
         ";
        $view->registerJs($script);
        $redraw = "
            // Fix for charts under tabs
            $('ul.nav a').on('shown.bs.tab', function () {
                morris_donut_{$this->id}.redraw();
            });
        ";
        $view->registerJs($redraw);
    }
}
