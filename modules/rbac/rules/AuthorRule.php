<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 12.10.16
 * Time: 16:56
 */

namespace modules\rbac\rules;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
    /**
     * @inheritdoc
     */
    public $name = 'isAuthor';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return isset($params['model']) ? $params['model']['id'] == $user : false;
    }
}