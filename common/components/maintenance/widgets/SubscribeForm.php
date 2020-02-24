<?php


namespace common\components\maintenance\widgets;

use yii\base\Widget;
use common\components\maintenance\models\SubscribeForm as SubscribeFormModel;

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
            echo $this->render('subscribe-form', ['model' => $this->model]);
        }
    }
}
