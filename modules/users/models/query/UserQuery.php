<?php

namespace modules\users\models\query;

use modules\users\models\User;
use yii\db\ActiveQuery;

/**
 * Class UserQuery
 * @package modules\users\models\query
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
