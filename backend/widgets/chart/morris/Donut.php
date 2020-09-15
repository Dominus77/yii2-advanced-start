<?php

namespace backend\widgets\chart\morris;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Donut
 *
 * @package backend\widgets\chart\morris
 */
class Donut extends Base
{
    /**
     * Client Options
     *
     * @return array
     */
    public function getClientOptions()
    {
        $clientOptions = ArrayHelper::merge(parent::getClientOptions(), [
            'colors' => [],
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
            let morris_donut_{$this->id} = new Morris.Donut({$clientOptions});
            // Fix for charts under tabs
            $('a[data-toggle=tab').on('shown.bs.tab', function () {
                morris_donut_{$this->id}.redraw();
            });
         ";
        $view->registerJs($script);
    }
}
