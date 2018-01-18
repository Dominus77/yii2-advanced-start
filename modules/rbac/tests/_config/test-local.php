<?php

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../../../common/config/test-local.php'),
    require(__DIR__ . '/../../../../frontend/config/test-local.php'),
    require(__DIR__ . '/test.php'),
    [
    ]
);
