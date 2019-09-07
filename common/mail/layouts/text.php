<?php

use yii\mail\MessageInterface;
use yii\web\View;

/* @var $this View view component instance */
/* @var $message MessageInterface the message being composed */
/* @var $content string main view render result */

$this->beginPage();
$this->beginBody();
echo $content;
$this->endBody();
$this->endPage();
