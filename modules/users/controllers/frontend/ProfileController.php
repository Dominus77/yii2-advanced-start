<?php

namespace modules\users\controllers\frontend;

use yii\filters\AccessControl;

/**
 * Class ProfileController
 * @package modules\users\controllers\frontend
 */
class ProfileController extends \modules\users\controllers\common\ProfileController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }
}
