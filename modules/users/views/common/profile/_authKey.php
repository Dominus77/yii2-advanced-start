<?php

use yii\helpers\Html;
use modules\users\Module;

/**
 * @var $model modules\users\models\User
 */

$key = Html::tag('code', $model->auth_key, ['id' => 'authKey']);
$link = Html::a(Module::translate('module', 'Generate'), ['/profile/generate-auth-key'], [
    'class' => 'btn btn-sm btn-default',
    'title' => Module::translate('module', 'Generate new key'),
    'data' => [
        'toggle' => 'tooltip',
    ],
    'onclick' => "                                
        $.ajax({
            type: 'POST',
            cache: false,
            url: this.href,
            success: function(response) {                                       
                if(response.success) {
                    $('#authKey').html(response.success);
                }
            }
        });
        return false;
    ",
]);

echo $key . ' ' . $link;
