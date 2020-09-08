<?php

namespace modules\users\widgets\passfield;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\InputWidget;
use modules\users\widgets\passfield\assets\PassfieldAsset;

/**
 * Class Passfield
 * @package modules\users\widgets\passfield
 */
class Passfield extends InputWidget
{
    /**
     * @var ActiveForm
     */
    public $form;
    /**
     * @var array Passfield options
     */
    public $config = [];

    /**
     * @var string
     */
    public $label;

    /**
     * @inheritdoc
     * @return $this|string
     * @throws InvalidConfigException
     */
    public function run()
    {
        $this->registerAssets();
        if ($this->hasModel()) {
            if ($this->form === null) {
                throw new InvalidConfigException(__CLASS__ . '.form property must be specified');
            }
            if (empty($this->label)) {
                return $this->form->field($this->model, $this->attribute)->passwordInput($this->options);
            }
            return $this->form->field(
                $this->model,
                $this->attribute
            )->passwordInput($this->options)->label($this->label);
        }
        return Html::passwordInput($this->name, $this->value, $this->options);
    }

    /**
     * Register Assets
     */
    public function registerAssets()
    {
        PassfieldAsset::register($this->view);
        $config = empty($this->config) ? json_encode(['locale' => Yii::$app->language]) : json_encode($this->config);
        $this->view->registerJs(sprintf('$("#%s").passField(%s)', $this->options['id'], $config));
    }
}
