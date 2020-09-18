<?php

namespace backend\widgets\chart\flot;

use yii\base\Widget;
use backend\widgets\chart\flot\assets\FlotAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

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
        FlotAsset::register($view);
        $clientData = Json::encode($this->getClientData());
        $clientOptions = Json::encode($this->getClientOptions());
        $demoDataUrl = Url::to(['/main/default/get-demo-data']);
        $script = "
            let plot_{$this->id} = $.plot('#{$this->id}', {$clientData}, {$clientOptions});
            
            let url = '$demoDataUrl',
                data = plot_{$this->id}.getData()[0].data;
            
            function getRandomData() {
                $.ajax({
                    url: url,
                    dataType: 'json',
                    type: 'post',
                    data: {data: data},
                }).done(function (response) {
                    console.log(response.result);
                    data = response.result;
                }).fail(function (response) {
                    console.log(response.result);
                });
                return data;
            }
            
            var updateInterval = 500; //Fetch data ever x milliseconds
            var realtime = 'on'; //If == to on then fetch data every x seconds. else stop fetching
            
            function update() {
                plot_{$this->id}.setData([getRandomData()]);                
                // Since the axes don't change, we don't need to call plot.setupGrid()
                plot_{$this->id}.draw();
                if (realtime === 'on') {
                    setTimeout(update, updateInterval);
                }
            }
            
            //INITIALIZE REALTIME DATA FETCHING
            if (realtime === 'on') {
                update();
            }
            
            //REALTIME TOGGLE
            $('#realtime .btn').click(function () {
                if ($(this).data('toggle') === 'on') {
                    realtime = 'on';
                } else {
                    realtime = 'off';
                }
                update();
            });
        ";
        $view->registerJs($script);
    }
}
