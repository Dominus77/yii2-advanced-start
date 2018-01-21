<?php
namespace modules\main;

use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 * @package modules\main
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        // i18n
        $app->i18n->translations['modules/main/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/main/messages',
            'fileMap' => [
                'modules/main/module' => 'module.php',
                'modules/main/backend' => 'backend.php',
                'modules/main/frontend' => 'frontend.php',
            ],
        ];

        // Rules
        $app->getUrlManager()->addRules(
            [
                // объявление правил здесь
                '' => 'main/default/index',
                '<_a:(about|contact|captcha)>' => 'main/default/<_a>',
            ]
        );
    }
}
