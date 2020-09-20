<?php

namespace backend\widgets\chart\flot;

use yii\base\Widget;
use backend\widgets\chart\flot\assets\FlotAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class Chart
 *
 * @package backend\widgets\chart\flot
 */
class Chart extends Widget
{
    const REALTIME_ON = 'on';
    const REALTIME_OFF = 'off';

    /** @var bool */
    public $status = true;
    /** @var array */
    public $containerOptions = [];
    /** @var array */
    public $clientOptions = [];
    /** @var array */
    public $clientData = [];
    /** @var bool */
    public $realtime = [
        'on' => false,
        'dataUrl' => '#',
        'btnGroupId' => '',
        'btnDefault' => '',
        'updateInterval' => 1000,
    ];

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
        $this->realtime['btnDefault'] = empty($this->realtime['btnDefault']) ?
            self::REALTIME_OFF : $this->realtime['btnDefault'];
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
        $script = "
            let plot_{$this->id} = $.plot('#{$this->id}', {$clientData}, {$clientOptions});
        ";
        $view->registerJs($script);

        // Realtime
        if ($this->realtime['on'] === true) {
            $dataUrl = $this->realtime['dataUrl'];
            $btnGroupId = $this->realtime['btnGroupId'];
            $btnDefault = $this->realtime['btnDefault'];
            $updateInterval = $this->realtime['updateInterval'];
            $on = self::REALTIME_ON;
            $off = self::REALTIME_OFF;
            $script = "                
                let url_{$this->id} = '$dataUrl',
                    data_{$this->id} = (plot_{$this->id}.getData().length === 0) ? [plot_{$this->id}.getData()] : 
                        plot_{$this->id}.getData()[0].data,
                    updateInterval_{$this->id} = {$updateInterval},
                    realtime_{$this->id} = '{$btnDefault}',
                    btnRealtime_{$this->id} = $('#{$btnGroupId} .btn');
                    
                // GET DATA AJAX
                function getDataAjax_{$this->id}() {
                    $.ajax({
                        url: url_{$this->id},
                        dataType: 'json',
                        type: 'post',
                        data: {data: data_{$this->id}},
                    }).done(function (response) {                    
                        data_{$this->id} = response.result;
                    }).fail(function (response) {
                        console.log(response.result);
                    });
                    return data_{$this->id};
                }
                
                // UPDATE
                function update_{$this->id}() {
                    plot_{$this->id}.setData([getDataAjax_{$this->id}()]);
                    plot_{$this->id}.setupGrid();
                    // Since the axes don't change, we don't need to call plot.setupGrid()
                    plot_{$this->id}.draw();
                    if (realtime_{$this->id} === '{$on}') {
                        setTimeout(update_{$this->id}, updateInterval_{$this->id});
                    }
                }
                
                // INITIALIZE REALTIME DATA FETCHING
                if (realtime_{$this->id} === '{$on}') {
                    update_{$this->id}();
                }
                
                // REALTIME TOGGLE                
                btnRealtime_{$this->id}.click(function () {                
                    btnRealtime_{$this->id}.addClass('btn-default');
                    $(this).removeClass('btn-default');                
                    if ($(this).data('toggle') === '{$on}') {
                        if(realtime_{$this->id} !== '{$on}') {
                            realtime_{$this->id} = '{$on}';
                            btnRealtime_{$this->id}.removeClass('btn-danger');                        
                            $(this).addClass('btn-success');
                            update_{$this->id}();
                        }                                    
                    } else {
                        if(realtime_{$this->id} !== '{$off}') {
                            realtime_{$this->id} = '{$off}'; 
                            btnRealtime_{$this->id}.removeClass('btn-success');                        
                            $(this).addClass('btn-danger');
                            update_{$this->id}();
                        }
                    }
                });
            ";
            $view->registerJs($script);
        }
    }
}
