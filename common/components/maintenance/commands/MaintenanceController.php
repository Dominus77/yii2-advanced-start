<?php

namespace common\components\maintenance\commands;

use yii\helpers\Console;
use yii\console\Controller;
use yii\base\Module;
use common\components\maintenance\StateInterface;

/**
 * Class MaintenanceController
 * @package common\components\maintenance\commands
 */
class MaintenanceController extends Controller
{
    /**
     * @var StateInterface
     */
    protected $state;

    public function __construct(string $id, Module $module, StateInterface $state, array $config = [])
    {
        $this->state = $state;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        if ($this->state->isEnabled()) {
            $enabled = $this->ansiFormat('ENABLED', Console::FG_RED);
            $this->stdout("Maintenance Mode is $enabled!\n");
            $this->stdout("use:\nphp yii maintenance/disable\nto disable maintenance mode.\n");
        } else {
            $this->stdout("Maintenance Mode is disabled.\n");
            $this->stdout("use:\nphp yii maintenance/enable\nto enable maintenance mode.\n");
        }

    }

    public function actionEnable()
    {
        $this->state->enable();
        $enabled = $this->ansiFormat('ENABLED', Console::FG_RED);
        $this->stdout("Maintenance Mode has been $enabled!\n");
        $this->stdout("Use:\nphp yii maintenance/disable\nto disable maintenance mode.\n");
    }

    public function actionDisable()
    {
        $this->state->disable();
        $this->stdout("Maintenance Mode has been disabled.\n");
        $this->stdout("Use:\nphp yii maintenance/enable\nto enable maintenance mode.\n");
    }
}

