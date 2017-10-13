<?php
/**
 * Created by PhpStorm.
 * User: Alexey Schevchenko <ivanovosity@gmail.com>
 * Date: 18.10.16
 * Time: 10:41
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;

class BackendController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'error')
            $this->layout = 'error.php';

        return parent::beforeAction($action);
    }
}