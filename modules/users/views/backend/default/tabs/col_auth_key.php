<?php

use yii\helpers\Html;
use modules\users\Module;

/* @var $this yii\web\View */
/* @var $model modules\users\models\User */

$this->registerJs(new yii\web\JsExpression("
    $(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();
        $('#auth_key_link').click(ajaxLinkGenerateAuthKey);
    });
"), yii\web\View::POS_END);
?>
<div id="auth_key_container">
    <div class="col-md-6">
        <code><?= $model->auth_key ?></code>
    </div>
    <div class="col-md-6">
        <?= Html::a('<span class="glyphicon glyphicon-refresh"></span> ' . Module::t('module', 'Generate'), ['generate-auth-key', 'id' => $model->id], [
            'id' => 'auth_key_link',
            'class' => 'btn btn-sm btn-default',
            'title' => Module::t('module', 'Generate new key'),
            'data' => [
                'toggle' => 'tooltip',
                'pjax' => 0,
            ]
        ]); ?>
    </div>
</div>
