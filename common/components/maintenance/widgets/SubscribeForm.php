<?php


namespace common\components\maintenance\widgets;

use yii\base\Widget;
use common\components\maintenance\models\SubscribeForm as SubscribeFormModel;
use common\components\maintenance\widgets\assets\SubscribeFormAsset;

/**
 * Class SubscribeForm
 * @package common\components\maintenance\widgets
 */
class SubscribeForm extends Widget
{
    /**
     * @var bool
     */
    public $status = true;

    /**
     * @var SubscribeFormModel
     */
    public $model;

    public function init()
    {
        parent::init();
        $this->model = $this->model ?: new SubscribeFormModel();
    }

    /**
     * @return string|void
     */
    public function run()
    {
        if ($this->status === true) {
            $this->registerResource();
            echo $this->render('subscribe-form', ['model' => $this->model]);
        }
    }

    /**
     * Register resource
     */
    protected function registerResource()
    {
        $view = $this->getView();
        SubscribeFormAsset::register($view);
    }
}
