<?php

namespace modules\users\models\query;

use modules\users\models\User;

/**
 * This is the ActiveQuery class for [[\modules\users\models\User]].
 *
 * @see \modules\users\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return \modules\users\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \modules\users\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

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
