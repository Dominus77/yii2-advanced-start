<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 26.10.16
 * Time: 14:50
 */
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\rbac\models\Rbac as BackendRbac;
use modules\users\Module;

?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
        <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
        <li><a href="#settings" data-toggle="tab">Settings</a></li>
    </ul>
    <div class="tab-content">
        <div class="active tab-pane" id="activity">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email:email',
                    [
                        'attribute' => 'role',
                        'format' => 'raw',
                        'value' => $model->userRoleName,
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => $model->statusLabelName,
                    ],
                    'last_visit:datetime',
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'attribute' => 'registration_type',
                        'format' => 'raw',
                        'value' => $model->registrationType,
                    ],
                ],
            ]) ?>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="timeline">
            <!-- The timeline -->
            <ul class="timeline timeline-inverse">
                <!-- timeline time label -->
                <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                        <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                        </div>
                        <div class="timeline-footer">
                            <a class="btn btn-primary btn-xs">Read more</a>
                            <a class="btn btn-danger btn-xs">Delete</a>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                        <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                        </h3>
                    </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                        <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                        </div>
                        <div class="timeline-footer">
                            <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline time label -->
                <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                        <div class="timeline-body">
                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                </li>
            </ul>
        </div>
        <!-- /.tab-pane -->

        <div class="tab-pane" id="settings">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-horizontal'
                ]
            ]); ?>

            <div class="col-sm-10">
                <?= $form->field($model, 'username')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Псевдоним',
                    'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
                ]) ?>
            </div>

            <div class="col-sm-10">
                <?= $form->field($model, 'first_name')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Имя',
                ]) ?>
            </div>

            <div class="col-sm-10">
                <?= $form->field($model, 'last_name')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Фамилия',
                ]) ?>
            </div>

            <div class="col-sm-10">
                <?= $form->field($model, 'email')->textInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                    //'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
                ]) ?>
            </div>

            <div class="col-sm-10">
                <?= $form->field($model, 'newPassword')->passwordInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Новый пароль',
                ]) ?>
            </div>

            <div class="col-sm-10">
                <?= $form->field($model, 'newPasswordRepeat')->passwordInput([
                    'maxlength' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Повторить пароль',
                ]) ?>
            </div>

            <div class="col-sm-10">
                <?= $form->field($model, 'role')->dropDownList($model->rolesArray, [
                    'class' => 'form-control',
                    'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
                ]) ?>
            </div>

            <div class="col-sm-10">
                <?= $form->field($model, 'status')->dropDownList($model->statusesArray, [
                    'class' => 'form-control',
                    'disabled' => Yii::$app->user->can(BackendRbac::ROLE_ADMINISTRATOR) ? false : true,
                ]) ?>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <?= Html::submitButton($model->isNewRecord ? '<span class="fa fa-plus"></span> ' . Module::t('backend', 'BUTTON_CREATE') : '<span class="fa fa-floppy-o"></span> ' . Module::t('backend', 'BUTTON_SAVE'), [
                        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                        'name' => 'submit-button',
                    ]) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>
<!-- /.nav-tabs-custom -->