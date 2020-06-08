<?php

use modules\users\widgets\AvatarWidget;

/* @var $model modules\users\models\User */

?>
<div class="row">
    <div class="col-sm-12 text-center">
        <?= AvatarWidget::widget([
            'email' => $model->profile->email_gravatar,
            'user_id' => $model->id,
            'imageOptions' => [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'width:60px',
                'alt' => 'avatar_' . $model->username,
            ]
        ]) ?>
        <?= $model->username ?>
    </div>
</div>
