<?php

namespace backend\widgets\chart\morris;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Chart
 *
 * @package backend\widgets\chart\morris
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
            'xkey' => 'y',
            'ykeys' => [],
            'labels' => [],
            'lineColors' => [],
        ]);
        return ArrayHelper::merge($clientOptions, $this->clientOptions);
    }

    /**
     * Register Asset
     */
    public function registerAsset()
    {
        parent::registerAsset();
        $view = $this->getView();
        $clientOptions = Json::encode($this->getClientOptions());
        $script = "
            let morris_area_{$this->id} = new Morris.Chart({$clientOptions});
            // Fix for charts under tabs
            $('a[data-toggle=tab').on('shown.bs.tab', function () {
                morris_area_{$this->id}.redraw();
            });
         ";
        $view->registerJs($script);
    }
}
