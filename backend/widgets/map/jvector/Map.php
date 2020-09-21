<?php

namespace backend\widgets\map\jvector;

use yii\base\InvalidArgumentException;
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
    /** @var array */
    public $maps = [];

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
        $mapsArray = $this->getMapsArray();
        $value = str_replace('-', '_', $mapsArray[key($mapsArray)]);
        $clientOptions = ['map' => $value,];
        $clientOptions = ArrayHelper::merge($clientOptions, $this->clientOptions);
        if (!empty($mapsArray[$clientOptions['map']])) {
            ArrayHelper::setValue(
                $clientOptions,
                'map',
                str_replace('-', '_', $mapsArray[$clientOptions['map']])
            );
            return $clientOptions;
        }
        throw new InvalidArgumentException(
            'Map "' . $clientOptions['map'] .
            '" is missing from the array: \'maps\' => [\'' . $clientOptions['map'] . '\' => \'' .
            str_replace('_', '-', $clientOptions['map']) . '\']'
        );
    }

    /**
     * @return array
     */
    public function getMapsArray()
    {
        $maps = ['world_mill_en' => 'world-mill-en'];
        return ArrayHelper::merge($maps, $this->maps);
    }

    /**
     * Register Asset
     */
    public function registerAsset()
    {
        $id = $this->id;
        $view = $this->getView();
        $clientOptions = $this->getClientOptions();
        MapAsset::$maps = $this->getMapsArray();
        MapAsset::$mapName = $clientOptions['map'];
        MapAsset::register($view);

        $clientOptionsJson = Json::encode($clientOptions);
        $script = "
            let map_{$id} = $('#{$id}').vectorMap({$clientOptionsJson});
        ";
        $view->registerJs($script);
    }
}
