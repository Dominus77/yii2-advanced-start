<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 12.10.16
 * Time: 14:59
 */

namespace backend\components\rbac\rules;

use Yii;
use yii\rbac\Rule;

class UserManagerRule extends Rule
{
    /**
     * @inheritdoc
     */
    public $name = 'userOneProfile';
    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return isset($params['model']) ? $params['model']['id'] == $user : false;
    }
}