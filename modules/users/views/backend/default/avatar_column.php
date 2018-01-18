<?php

use yii\helpers\Html;

/* @var $model modules\users\models\backend\User */
?>

<?php if ($path = $model->avatarPath) : ?>
    <div class="row">
        <div class="col-sm-12 text-center">
            <?= Html::img($model->avatarPath, [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'width:60px',
                'alt' => 'avatar_' . $model->username,
            ]); ?>
            <div><?= $model->username; ?></div>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-sm-12 text-center">
            <?= $model->getGravatar(null, 80, 'mm', 'g', true, [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'width:60px',
                'alt' => 'avatar_' . $model->username,
            ]); ?>
            <?= $model->username; ?>
        </div>
    </div>
<?php endif; ?>
