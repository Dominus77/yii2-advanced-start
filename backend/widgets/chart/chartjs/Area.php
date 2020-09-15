<?php

namespace backend\widgets\chart\chartjs;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Area
 *
 * @package backend\widgets\chart\chartjs
 *
 */
class Area extends Base
{
    /**
     * Client Options
     *
     * @return array
     */
    public function getClientOptions()
    {
        $clientOptions = ArrayHelper::merge(parent::getClientOptions(), [
            'showScale' => true,
            'scaleShowGridLines' => false,
            'scaleGridLineColor' => 'rgba(0,0,0,.05)',
            'scaleGridLineWidth' => 1,
            'scaleShowHorizontalLines' => true,
            'scaleShowVerticalLines' => true,
            'bezierCurve' => true,
            'bezierCurveTension' => 0.3,
            'pointDot' => false,
            'pointDotRadius' => 4,
            'pointDotStrokeWidth' => 1,
            'pointHitDetectionRadius' => 20,
            'datasetStroke' => true,
            'datasetStrokeWidth' => 2,
            'datasetFill' => true,
            'maintainAspectRatio' => true,
            'responsive' => true,
        ]);
        return ArrayHelper::merge($clientOptions, $this->clientOptions);
    }

    /**
     * Client Data
     *
     * @return array
     */
    public function getClientData()
    {
        $clientData = ArrayHelper::merge(parent::getClientData(), [
            'labels' => [],
            'datasets' => [],
        ]);
        return ArrayHelper::merge($clientData, $this->clientData);
    }

    /**
     * Register Asset
     */
    public function registerAsset()
    {
        parent::registerAsset();
        $view = $this->getView();
        $clientData = Json::encode($this->getClientData());
        $clientOptions = Json::encode($this->getClientOptions());
        $script = "            
            let areaChartCanvas = $('#{$this->id}').get(0).getContext('2d');
            let areaChart = new Chart(areaChartCanvas).Line({$clientData}, {$clientOptions});            
         ";
        $view->registerJs($script);
    }
}
