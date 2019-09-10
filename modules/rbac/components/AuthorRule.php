<?php

namespace modules\rbac\components;

use yii\rbac\Rule;

/**
 * Class AuthorRule
 * @package modules\rbac\components
 *
 * @property string $name Name
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|integer $user ID пользователя.
     * @param string $item роль или разрешение с которым это правило ассоциировано
     * @param array $params параметры, переданные в ManagerInterface::checkAccess(), например при вызове проверки
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return isset($params['post']) ? $params['post']->author_id === $user : false;
    }
}
