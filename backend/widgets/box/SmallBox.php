<?php

namespace backend\widgets\box;

use yii\base\Widget;
use yii\helpers\Html;
use common\assets\IonIconsAsset;

/**
 * Class SmallBox
 *
 * @package backend\widgets\box
 */
class SmallBox extends Widget
{
    const BG_GREEN = 'bg-green';
    const BG_AQUA = 'bg-aqua';
    const BG_YELLOW = 'bg-yellow';
    const BG_RED = 'bg-red';
    const BG_GRAY = 'bg-gray';
    const BG_BLACK = 'bg-black';
    const BG_MAROON = 'bg-maroon';
    const BG_PURPLE = 'bg-purple';
    const BG_TEAL = 'bg-teal';
    const BG_NAVY = 'bg-navy';
    const BG_PRIMARY = 'bg-primary';
    const BG_SUCCESS = 'bg-success';
    const BG_WARNING = 'bg-warning';
    const BG_INFO = 'bg-info';
    const BG_DANGER = 'bg-danger';

    /**
     * @var bool
     */
    public $status = true;
    /**
     * @var string
     */
    public $header;
    /**
     * @var string icon name
     * @see: http://ionicons.com
     */
    public $icon;
    /**
     * @var string
     */
    public $content;
    /**
     * @var array|string|null
     *
     * ['label' => '', 'url' => ['#']];
     */
    public $link;
    /**
     * @var string
     */
    public $style;

    /**
     * Run
     *
     * @return string
     */
    public function run()
    {
        if ($this->status === true) {
            $this->registerAssets();
            return $this->renderContent();
        }
        return '';
    }

    /**
     * Render Content
     *
     * @return string
     */
    public function renderContent()
    {
        $str = '';
        $str .= Html::beginTag('div', ['id' => $this->id, 'class' => 'small-box ' . $this->style]) . PHP_EOL;
        $str .= Html::beginTag('div', ['class' => 'inner']) . PHP_EOL;
        $str .= Html::tag('h3', $this->header) . PHP_EOL;
        $str .= Html::tag('p', $this->content) . PHP_EOL;
        $str .= Html::endTag('div') . PHP_EOL;
        $str .= Html::beginTag('div', ['icon']) . PHP_EOL;
        $str .= Html::tag('i', '', ['class' => 'icon ' . $this->icon]) . PHP_EOL;
        $str .= Html::endTag('div') . PHP_EOL;
        if (is_array($this->link)) {
            if (!empty($this->link['label']) && !empty($this->link['url'])) {
                $str .= Html::a($this->link['label'], $this->link['url'], [
                        'class' => 'small-box-footer'
                    ]) . PHP_EOL;
            }
        } elseif (!is_null($this->link)) {
            $str .= Html::tag('div', $this->link, ['class' => 'small-box-footer']);
        }
        $str .= Html::endTag('div') . PHP_EOL;
        return $str;
    }

    /**
     * Register Assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        IonIconsAsset::register($view);
    }
}
