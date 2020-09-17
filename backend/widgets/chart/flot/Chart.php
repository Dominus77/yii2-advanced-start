<?php

namespace backend\widgets\chart\flot;

use yii\base\Widget;
use backend\widgets\chart\flot\assets\FlotAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * Class Chart
 *
 * @package backend\widgets\chart\flot
 */
class Chart extends Widget
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
     * Client Options
     *
     * @return array
     */
    public function getClientOptions()
    {
        $clientOptions = [
            'grid' => [
                'borderColor' => '#f3f3f3',
                'borderWidth' => 1,
                'tickColor' => '#f3f3f3'
            ],
            'series' => [
                'shadowSize' => 0,
                'lines' => [
                    'show' => true
                ],
            ],
            'lines' => [
                'fill' => false,
                'color' => '#f56954',
            ],
            'yaxis' => [
                'min' => 0,
                'max' => 100,
                'show' => true,
            ],
            'xaxis' => [
                'show' => true,
            ]
        ];
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
        FlotAsset::register($view);
        $clientData = Json::encode($this->getClientData());
        $clientOptions = Json::encode($this->getClientOptions());
        $demoDataUrl = Url::to(['/main/default/get-demo-data']);
        /*$script = "
            let url = '$demoDataUrl';
            function getRandomData() {
                $.ajax({
                    url: url,
                    dataType: 'json',
                    type: 'post',
                }).done(function (response) {
                    console.log(response.result);
                }).fail(function (response) {
                    console.log(response.result);
                });
            }
        ";*/
        //$view->registerJs($script);

        $script = "
            let plot_{$this->id} = $.plot('#{$this->id}', {$clientData}, {$clientOptions});
            console.log(plot_{$this->id}.getData()[0].data);
        ";
        $view->registerJs($script);
    }
}
