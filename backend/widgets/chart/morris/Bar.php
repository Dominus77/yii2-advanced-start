<?php

namespace backend\widgets\chart\morris;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class Bar
 *
 * @package backend\widgets\chart\morris
 */
class Bar extends Base
{
    /**
     * Client Options
     *
     * @return array
     */
    public function getClientOptions()
    {
        $clientOptions = ArrayHelper::merge(parent::getClientOptions(), [
            'barColors' => [],
            'xkey' => 'y',
            'ykeys' => [],
            'labels' => [],
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
            let morris_bar_{$this->id} = new Morris.Bar({$clientOptions});
            // Fix for charts under tabs
            $('a[data-toggle=tab').on('shown.bs.tab', function () {
                morris_bar_{$this->id}.redraw();
            });
         ";
        $view->registerJs($script);
    }
}
