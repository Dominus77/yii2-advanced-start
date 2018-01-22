<?php
namespace modules\main;

use Yii;

/**
 * Class Bootstrap
 * @package modules\main
 */
class Bootstrap
{
    public function __construct()
    {
        Yii::$app->i18n->translations['modules/main/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/main/messages',
            'fileMap' => [
                'modules/main/module' => 'module.php',
                'modules/main/backend' => 'backend.php',
                'modules/main/frontend' => 'frontend.php',
            ],
        ];

        // Rules
        Yii::$app->getUrlManager()->addRules(
            [
                // объявление правил здесь
                '' => 'main/default/index',
                '<_a:(about|contact|captcha)>' => 'main/default/<_a>',
            ]
        );
    }
}
