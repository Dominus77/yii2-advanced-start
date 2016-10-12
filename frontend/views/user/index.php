<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'NAV_PROFILE');
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="user-index">
    <div class="row">
        <div class="col-md-12">
            <?= TabsX::widget([
                'position' => TabsX::POS_ABOVE,
                'align' => TabsX::ALIGN_LEFT,
                'bordered' => true,
                'items' => [
                    [
                        'label' => Yii::t('app', 'TITLE_REGISTRATION_DATA'),
                        'content' => $this->render('_user', ['model' => $model]),
                        'active' => Yii::$app->request->get('tab') == 'user' ? true : false,
                    ],
                    /*[
                        'label' => Yii::t('app', 'TITLE_MY_PROFILE'),
                        'content' => $this->render('_profile', ['model' => $model->profile ? $model->profile : false]),
                        'active' => Yii::$app->request->get('tab') == 'profile' ? true : false,
                    ]*/
                ],
            ]);
            ?>
        </div>
    </div>
</div>
