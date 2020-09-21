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
        $id = $this->id;
        $view = $this->getView();
        $clientOptions = $this->getClientOptions();
        MapAsset::$mapName = $clientOptions['map'];
        MapAsset::register($view);

        $clientOptionsJson = Json::encode($clientOptions);
        $script = "
            let map_{$id} = $('#{$id}').vectorMap({$clientOptionsJson});
        ";
        $view->registerJs($script);
    }
}
