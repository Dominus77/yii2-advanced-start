<?php

namespace modules\users\controllers\frontend;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'delete-avatar' => ['post']
                ]
            ]
        ];
    }
}
