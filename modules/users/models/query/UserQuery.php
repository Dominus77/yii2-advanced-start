<?php

namespace modules\users\models\query;

use yii\db\ActiveQuery;
use modules\users\models\User;

/**
 * This is the ActiveQuery class for [[\modules\users\models\User]].
 *
 * @see \modules\users\models\User
 */
class UserQuery extends ActiveQuery
{
    /**
     * @param int $timeout
     * @return $this
     */
    public function overdue($timeout)
    {
        return $this
            ->andWhere(['status' => User::STATUS_WAIT])
            ->andWhere(['<', 'created_at', time() - $timeout]);
    }
}
