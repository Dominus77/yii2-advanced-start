<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Class AppAsset
 * @package backend\assets
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];
    public $js = [];

    public function init()
    {
        parent::init();
        $this->css[] = 'css/site.css';
        $this->js[] = 'js/dashboard.js';

        $message = [
            'confirmButtonText' => Yii::t('app', 'Yes, delete!'),
            'cancelButtonText' => Yii::t('app', 'No, do not delete!'),
        ];

        $view = \Yii::$app->getView();
        $view->registerJs(new \yii\web\JsExpression("
            yii.confirm = function (message, okCallback, cancelCallback) {
                swal({
                    title: message,
                    type: 'warning',
                    showCancelButton: true,
                    closeOnConfirm: true,
                    allowOutsideClick: true,
                    confirmButtonText: \"{$message['confirmButtonText']}\",
                    cancelButtonText: \"{$message['cancelButtonText']}\"
                }).then(okCallback);
            };
        "));
    }

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\BootstrapAsset',
        'common\assets\Html5ShivAsset',
        'common\assets\RespondAsset',
        'common\assets\FontAwesomeAsset',
        'common\assets\IonIconsAsset',
        'backend\assets\plugins\SlimScrollAsset',
        'backend\assets\plugins\FastClickAsset',
        'backend\assets\AdminLteAsset',
        'dominus77\sweetalert2\assets\SweetAlert2Asset',
    ];
}
