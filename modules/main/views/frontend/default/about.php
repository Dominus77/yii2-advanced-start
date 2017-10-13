<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use modules\main\Module;

$this->title = Module::t('module', 'About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-frontend-default-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is the About page. You may modify the following file to customize its content:</p>

    <code><?= __FILE__ ?></code>
</div>
