<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 12.10.16
 * Time: 8:35
 */

namespace common\components\widgets\passfield;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;
use common\components\widgets\passfield\assets\PassfieldAsset;

class Passfield extends InputWidget
{
    /**
     * @var \yii\widgets\ActiveForm
     */
    public $form;
    /**
     * @var array Passfield options
     */
    public $config = [];
    /**
     * @inheritdoc
     */
    public function run()
    {
        PassfieldAsset::register($this->view);
        $config = empty($this->config) ? json_encode(['locale' => \Yii::$app->language]) : json_encode($this->config);
        $this->view->registerJs(sprintf('$("#%s").passField(%s)', $this->options['id'], $config));
        if ($this->hasModel()) {
            if ($this->form == null) {
                throw new InvalidConfigException(__CLASS__ . '.form property must be specified');
            }
            return $this->form->field($this->model, $this->attribute)->passwordInput($this->options);
        } else {
            return Html::passwordInput($this->name, $this->value, $this->options);
        }
    }
}