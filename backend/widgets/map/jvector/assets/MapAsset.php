<?php

namespace backend\widgets\map\jvector\assets;

use yii\base\InvalidArgumentException;
use yii\web\AssetBundle;

/**
 * Class Map
 *
 * @package backend\widgets\map\jvector\assets
 */
class MapAsset extends AssetBundle
{
    /** @var array */
    public static $maps = [];
    /** @var string */
    public static $mapName = 'world_mill_en';

    /** @var array|null */
    private $mapsArray;
    /** @var string|null */
    private $map;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src/maps';
        $this->setMaps(self::$maps);
        $maps = $this->getMaps();
        if (is_array($maps) && !empty($maps[self::$mapName])) {
            $this->setMap($maps[self::$mapName]);
            $this->js = [
                'jquery-jvectormap-' . $this->getMap() . '.js'
            ];
        } else {
            throw new InvalidArgumentException(__class__ . ': Incorrect map name: "' . self::$mapName . '"');
        }
    }

    /**
     * @param array $maps
     */
    public function setMaps($maps = [])
    {
        $this->mapsArray = $maps;
    }

    /**
     * @return array|null
     */
    public function getMaps()
    {
        return $this->mapsArray;
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
