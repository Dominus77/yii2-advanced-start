<?php

namespace common\gii\generators\module;

use Yii;
use yii\gii\generators\module\Generator as BaseGenerator;
use yii\gii\CodeFile;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * Class Generator
 * @package common\gii\generators\module
 *
 * @property-read string $traitNameSpace
 * @property-read mixed $frontendControllerNamespace
 * @property-read mixed $backendControllerNamespace
 * @property-read string $name
 * @property-read mixed $consoleControllerNamespace
 */
class Generator extends BaseGenerator
{
    private $controllerNameSpace;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Module Advanced Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'This generator helps you to generate the skeleton code needed by a yii2-advanced-start module.';
    }

    /**
     * {@inheritdoc}
     */
    public function requiredTemplates()
    {
        return [
            'module.php',
            'bootstrap.php',
            'frontendController.php',
            'backendController.php',
            'consoleController.php',
            'viewFrontend.php',
            'viewBackend.php',
            'i18nEn.php',
            'i18nRu.php',
            'trait.php'
        ];
    }

    /**
     * @param string $string
     */
    public function setControllerNamespace($string = '')
    {
        $str = substr($this->moduleClass, 0, strrpos($this->moduleClass, '\\'));
        if ($string === 'commands') {
            $this->controllerNameSpace = $str . '\commands';
        } else {
            $this->controllerNameSpace = $str . '\controllers' . ($string ? '\\' . $string : '');
        }
    }

    /**
     * @return string the controller namespace of the module.
     */
    public function getControllerNamespace()
    {
        return $this->controllerNameSpace;
    }

    /**
     * @return mixed
     */
    public function getFrontendControllerNamespace()
    {
        $this->setControllerNamespace('frontend');
        return $this->controllerNameSpace;
    }

    /**
     * @return mixed
     */
    public function getBackendControllerNamespace()
    {
        $this->setControllerNamespace('backend');
        return $this->controllerNameSpace;
    }

    /**
     * @return mixed
     */
    public function getConsoleControllerNamespace()
    {
        $this->setControllerNamespace('commands');
        return $this->controllerNameSpace;
    }

    /**
     * @return string
     */
    public function getTraitNameSpace()
    {
        return substr($this->moduleClass, 0, strrpos($this->moduleClass, '\\')) . '\traits';
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $files = [];
        $modulePath = $this->getModulePath();
        $files[] = new CodeFile(
            $modulePath . '/' . StringHelper::basename($this->moduleClass) . '.php',
            $this->render('module.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/Bootstrap.php',
            $this->render('bootstrap.php')
        );
        $this->setControllerNamespace('frontend');
        $files[] = new CodeFile(
            $modulePath . '/controllers/frontend/DefaultController.php',
            $this->render('frontendController.php')
        );
        $this->setControllerNamespace('backend');
        $files[] = new CodeFile(
            $modulePath . '/controllers/backend/DefaultController.php',
            $this->render('backendController.php')
        );
        $this->setControllerNamespace('commands');
        $files[] = new CodeFile(
            $modulePath . '/commands/DefaultController.php',
            $this->render('consoleController.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/views/backend/default/index.php',
            $this->render('viewBackend.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/views/frontend/default/index.php',
            $this->render('viewFrontend.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/messages/en/module.php',
            $this->render('i18nEn.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/messages/ru/module.php',
            $this->render('i18nRu.php')
        );
        $files[] = new CodeFile(
            $modulePath . '/traits/' . StringHelper::basename($this->moduleClass) . 'Trait.php',
            $this->render('trait.php')
        );

        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function hints()
    {
        $moduleID = 'This refers to the ID of the module, e.g., <code>admin</code>.';
        $moduleClass = 'This is the fully qualified class name of the module, e.g., <code>modules\admin\Module</code>.';
        return [
            'moduleID' => $moduleID,
            'moduleClass' => $moduleClass,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function successMessage()
    {
        if (Yii::$app->hasModule($this->moduleID)) {
            $link = Html::a('try it now', Yii::$app->getUrlManager()->createUrl($this->moduleID), [
                'target' => '_blank'
            ]);

            return "The module has been generated successfully. You may $link.";
        }
        $str = substr($this->moduleClass, 0, strrpos($this->moduleClass, '\\'));
        $output = <<<EOD
<p>The module has been generated successfully.</p>
<p>To access the module, you need to add this to your application configuration:</p>
EOD;
        $appCommon = <<<EOD
<p>common/config/main.php</p>
EOD;

        $codeCommon = <<<EOD
<?php
    ......
    'bootstrap' => [        
        '{$str}\Bootstrap',
    ],    
    ......
    'modules' => [
        '{$this->moduleID}' => [
            'class' => '{$this->moduleClass}',
        ],
    ],
    ......
EOD;
        $appBackend = <<<EOD
<p>backend/config/main.php</p>
EOD;
        $codeBackend = <<<EOD
<?php    
    ......
    'modules' => [
        '{$this->moduleID}' => [
            'isBackend' => true,
        ],
    ],   
    ......
EOD;

        return $output . $appCommon . '<pre>' . highlight_string($codeCommon, true) . '</pre>' .
            $appBackend . '<pre>' . highlight_string($codeBackend, true) . '</pre>';
    }
}
