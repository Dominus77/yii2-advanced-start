<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<p>
    <?= Html::a('<i class="fa fa-pencil"></i> '.Yii::t('app', 'UPDATE_DATA'), ['update'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('<i class="fa fa-user-secret"></i> '.Yii::t('app', 'PASSWORD_CHANGE'), ['password-change'], ['class' => 'btn btn-warning']) ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'username',
        'email',
        [
            'attribute' => 'created_at',
            'value' => Yii::$app->formatter->asDate($model->created_at, 'd MMM yyyy г., HH:mm:ss'),
        ],
        [
            'attribute' => 'updated_at',
            'value' => Yii::$app->formatter->asDate($model->updated_at, 'd MMM yyyy г., HH:mm:ss'),
        ],
        [
            'attribute' => 'last_visit',
            'value' => $model->last_visit ?
                Yii::$app->formatter->asDate($model->last_visit, 'd MMM yyyy г., HH:mm:ss') :
                '-',
        ],
        [
            'attribute' => 'role',
            'value' => $model->userRoleName,
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => $model->statusLabelName,
        ],
    ],
]) ?>