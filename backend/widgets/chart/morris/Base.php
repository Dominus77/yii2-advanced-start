<?php

namespace backend\widgets\chart\morris;

use backend\widgets\chart\morris\assets\MorrisAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Base
 *
 * @package backend\widgets\chart\morris
 */
abstract class Base extends Widget
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
        return [
            'element' => $this->id,
            'resize' => true,
            'hideHover' => 'auto',
            'data' => [],
        ];
    }

    /**
     * Register Asset
     */
    public function registerAsset()
    {
        $view = $this->getView();
        MorrisAsset::register($view);
    }
}
