<?php

use yii\helpers\Html;

/** @var string $icon */
/** @var string $title */

if (isset($icon)) {
    echo Html::tag('i', '', ['class' => $icon]) . ' ';
}
echo $title;
