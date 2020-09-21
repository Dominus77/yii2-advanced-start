<?php

namespace backend\widgets\map\jvector\assets;

use yii\base\InvalidArgumentException;
use yii\web\AssetBundle;

/**
 * Class Map
 *
 * @package backend\widgets\map\jvector\assets
 *
 * @property-read string[] $mapsArray
 */
class MapAsset extends AssetBundle
{
    /** @var string */
    public static $mapName = 'world_mill_en';
    /** @var string */
    public $sourcePath = __DIR__ . '/src/maps';
    /** @var string|null */
    private $map;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $maps = $this->getMapsArray();
        if (!empty($maps[self::$mapName])) {
            $this->setMap($maps[self::$mapName]);
            $this->js = [
                'jquery-jvectormap-' . $this->getMap() . '.js'
            ];
        } else {
            throw new InvalidArgumentException(__class__ . ': Incorrect map name: "' . self::$mapName . '"');
        }
    }

    /**
     * @return string[]
     */
    public function getMapsArray()
    {
        return [
            'world_mill_en' => 'world-mill-en'
        ];
    }

    /**
     * @param string $value
     */
    public function setMap($value = '')
    {
        $this->map = $value;
    }

    /**
     * @return string|null
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @var string[]
     */
    public $depends = [
        JVectorMapAsset::class,
    ];
}
