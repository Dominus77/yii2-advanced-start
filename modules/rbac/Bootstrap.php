<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 17.10.16
 * Time: 13:36
 */

namespace modules\rbac;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules(
            [
                // объявление правил здесь
                'rbac' => 'rbac/default/index',
            ]
        );
    }
}