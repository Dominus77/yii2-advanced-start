<?php

use modules\main\Module;
use backend\widgets\box\SmallBox;

/* @var $this yii\web\View */

$this->title = Module::translate('module', 'Home');
$this->params['title']['small'] = Module::translate('module', 'Dashboard');
?>

<section class="main-backend-default-index">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_AQUA,
                'icon' => 'ion-bag',
                'header' => 150,
                'content' => 'New Orders',
                'link' => ['label' => 'More info <i class="fa fa-arrow-circle-right"></i>', 'url' => ['#']]
            ]) ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_GREEN,
                'icon' => 'ion-stats-bars',
                'header' => '53<sup style="font-size: 20px">%</sup>',
                'content' => 'Bounce Rate',
                'link' => ['label' => 'More info <i class="fa fa-arrow-circle-right"></i>', 'url' => ['#']]
            ]) ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_YELLOW,
                'icon' => 'ion-person-add',
                'header' => 44,
                'content' => 'User Registrations',
                'link' => ['label' => 'More info <i class="fa fa-arrow-circle-right"></i>', 'url' => ['#']]
            ]) ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_RED,
                'icon' => 'ion-pie-graph',
                'header' => 65,
                'content' => 'Unique Visitors',
                'link' => ['label' => 'More info <i class="fa fa-arrow-circle-right"></i>', 'url' => ['#']]
            ]) ?>
        </div>
    </div>
</section>
