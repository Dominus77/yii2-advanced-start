<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 25.10.16
 * Time: 14:57
 */

use yii\helpers\Html;

?>

<?php if ($path = $model->avatarPath) : ?>
    <div class="row">
        <div class="col-sm-12 text-center">
            <?= Html::img($model->avatarPath, [
                'class' => 'profile-user-img img-responsive img-circle',
                'style' => 'width:60px',
                'alt' => 'avatar_' . $model->username,
                ''
            ]); ?>
            <div><?= $model->username; ?></div>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-sm-12 text-center">
                <i style="color:#b9b9b9; display:block;" class="fa fa-user-circle fa-4x"></i>
                <?= $model->username; ?>
        </div>
    </div>
<?php endif; ?>
