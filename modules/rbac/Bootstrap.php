<?php

namespace modules\rbac;

use Yii;

/**
 * Class Bootstrap
 * @package modules\rbac
 */
class Bootstrap
{
    public function __construct()
    {
        $this->registerTranslate();
        $this->registerRules();
    }

    /**
     * Translate
     */
    protected function registerTranslate()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['modules/rbac/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/rbac/messages',
            'fileMap' => [
                'modules/rbac/module' => 'module.php',
            ],
        ];
    }

    /**
     * Rules
     */
    protected function registerRules()
    {
        $urlManager = Yii::$app->urlManager;
        $urlManager->addRules($this->rules());
    }

    /**
     * @return array
     */
    protected function rules()
    {
        $rules = [];
        array_push($rules, $this->rulesRoles(), $this->rulesPermissions(), $this->rulesAssign(), $this->rulesDefault());
        return $rules;
    }

    /**
     * @return array
     */
    protected function rulesRoles()
    {
        return [
            'class' => 'yii\web\GroupUrlRule',
            'routePrefix' => 'rbac/roles',
            'prefix' => 'rbac',
            'rules' => [
                'roles' => 'index',
                'role/<id:[\w\-]+>/<_a:[\w\-]+>' => '<_a>',
                'role/<_a:[\w\-]+>' => '<_a>',
            ],
        ];
    }

    /**
     * @return array
     */
    protected function rulesPermissions()
    {
        return [
            'class' => 'yii\web\GroupUrlRule',
            'routePrefix' => 'rbac/permissions',
            'prefix' => 'rbac',
            'rules' => [
                'permissions' => 'index',
                'permission/<id:[\w\-]+>/<_a:[\w\-]+>' => '<_a>',
                'permission/<_a:[\w\-]+>' => '<_a>',
            ],
        ];
    }

    /**
     * @return array
     */
    protected function rulesAssign()
    {
        return [
            'class' => 'yii\web\GroupUrlRule',
            'routePrefix' => 'rbac/assign',
            'prefix' => 'rbac/assign',
            'rules' => [
                '' => 'index',
                '<id:\d+>/<_a:[\w\-]+>' => '<_a>',
            ],
        ];
    }

    /**
     * @return array
     */
    protected function rulesDefault()
    {
        return [
            'class' => 'yii\web\GroupUrlRule',
            'routePrefix' => 'rbac/default',
            'prefix' => 'rbac',
            'rules' => [
                '' => 'index',
                '<_a:[\w\-]+>' => '<_a>',
            ],
        ];
    }
}
