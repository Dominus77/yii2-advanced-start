<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\modules\user\Module;
?>

<div class="clearfix">
    <div class="col-lg-2">
        <div class="form-group">
            <?php if(isset($model->userImage) && $model->userImage): ?>
                <img src="<?= $model->userImage?>" class="img-responsive img-thumbnail">
            <?php else: ?>
                <div class="img-responsive img-thumbnail" style="border: 1px dashed lightgrey; background-color: #ECF0F5; color:#808080; text-align: center; width:160px; height:160px;">
                    <p style="margin-top: 65px">160x160</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-10">
        <?php if($model): ?>
            <p>
                <?= Html::a('<i class="fa fa-pencil"></i> '.Module::t('module', 'BUTTON_UPDATE'), ['user-profile/update'], ['class' => 'btn btn-primary']) ?>
            </p>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'surname',
                        'profile',
                        'phone',
                        'email:email',
                        [
                            'attribute' => 'about',
                            'format' => 'raw',
                        ]
                    ],
                ]) ?>
            <?php else: ?>
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> '.Module::t('module', 'BUTTON_CREATE'), ['user-profile/create'], ['class' => 'btn btn-success']) ?>
            <p>
            <p><?= Module::t('module', 'USER_PROFILE_NOT_CREATED')?></p>
        <?php endif; ?>
    </div>
</div>