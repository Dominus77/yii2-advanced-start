<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 17.10.16
 * Time: 13:36
 */

namespace modules\main;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // i18n
        $app->i18n->translations['modules/main/*'] = [
            'class'          => 'yii\i18n\PhpMessageSource',
            'basePath'       => '@modules/main/messages',
            'fileMap'        => [
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