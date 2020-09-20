<?php

namespace backend\widgets\map\jvector;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\widgets\map\jvector\assets\MapAsset;
use yii\helpers\Json;

/**
 * Class Map
 *
 * @package backend\widgets\map\jvector
 */
class Map extends Widget
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
            'map' => 'world_mill_en',
        ];
        return ArrayHelper::merge($clientOptions, $this->clientOptions);
    }

    /**
     * Register Asset
     */
    public function registerAsset()
    {
        $view = $this->getView();
        MapAsset::register($view);
        $id = $this->id;
        $clientOptions = Json::encode($this->getClientOptions());
        $script = "
            let map_{$id} = $('#{$id}').vectorMap({$clientOptions});
        ";
        $view->registerJs($script);
    }
}
