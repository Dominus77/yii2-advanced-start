<?php

namespace modules\users\widgets;

use modules\users\models\UploadForm;
use yii\base\InvalidArgumentException;
use yii\base\Widget;

/**
 * Class AvatarFormWidget
 * @package modules\users\widgets
 */
class UploadAvatarForm extends Widget
{
    /**
     * On/Off widget
     * @var bool
     */
    public $status = true;
    /**
     * @var UploadForm
     */
    public $model;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        if (($this->status === true) && !($this->model instanceof UploadForm)) {
            throw new InvalidArgumentException('The model is not an instance of class: ' . UploadForm::class);
        }
    }

    /**
     * @return string|void
     */
    public function run()
    {
        if ($this->status === true) {
            echo $this->render('uploadAvatarForm', [
                'model' => $this->model
            ]);
        }
    }
}
