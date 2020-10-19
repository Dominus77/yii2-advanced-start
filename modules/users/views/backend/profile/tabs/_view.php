<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\rbac\models\Assignment;
use modules\users\widgets\AvatarWidget;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\User
 * @var $assignModel Assignment
 */

$this->registerJs(new yii\web\JsExpression("
    $(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();        
    });
"), yii\web\View::POS_END);
?>

<div class="row">
    <div class="col-sm-2">
        <?= AvatarWidget::widget([
            'user_id' => $model->id
        ]) ?>
    </div>
    <div class="col-sm-10">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'profile.first_name',
                'profile.last_name',
                'email:email',
                [
                    'attribute' => 'userRoleName',
                    'format' => 'raw',
                    'value' => $assignModel->getRoleName($model->id),
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => $model->statusLabelName,
                ],
                [
                    'attribute' => 'auth_key',
                    'format' => 'raw',
                    'value' => $this->renderFile(
                        Yii::getAlias('@modules/users/views/common/profile/_authKey.php'),
                        [
                            'model' => $model
                        ]
                    )
                ],
                'created_at:datetime',
                'updated_at:datetime',
                'profile.last_visit:datetime',
            ],
        ]) ?>
    </div>
    <div class="col-sm-offset-2 col-sm-10">
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Module::translate(
            'module',
            'Update'
        ), ['update'], [
            'class' => 'btn btn-primary'
        ]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Module::translate(
            'module',
            'Delete'
        ), ['delete'], [
            'class' => 'btn btn-danger',
            'data' => [
                'method' => 'post'
            ]
        ]) ?>
    </div>
</div>
