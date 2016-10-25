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
        <div class="col-md-7  text-center">
            <div class="col-md-12">
                <?= Html::img($model->avatarPath, ['class' => 'img-circle img-responsive center-block', 'alt' => 'avatar_' . $model->username]); ?>
            </div>
            <div class="col-md-12">
                <?= $model->username; ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-md-7 text-center">
            <div class="col-md-12">
                <i style="color:#b9b9b9;" class="fa fa-user-circle fa-4x"></i>
            </div>
            <div class="col-md-12">
                <?= $model->username; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
