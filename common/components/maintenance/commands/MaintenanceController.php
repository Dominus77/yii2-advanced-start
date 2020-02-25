<?php

namespace common\components\maintenance\commands;

use yii\helpers\Console;
use yii\console\Controller;
use yii\base\Module;
use common\components\maintenance\StateInterface;

/**
 * Maintenance mode
 * @package common\components\maintenance\commands
 */
class MaintenanceController extends Controller
{
    /**
     * @var StateInterface
     */
    protected $state;
    protected $exampleData;

    /**
     * MaintenanceController constructor.
     * @param string $id
     * @param Module $module
     * @param StateInterface $state
     * @param array $config
     */
    public function __construct($id, Module $module, StateInterface $state, array $config = [])
    {
        $this->state = $state;
        $this->exampleData = $this->exampleDateFormat();
        parent::__construct($id, $module, $config);
    }

    /**
     * Maintenance commands
     */
    public function actionIndex()
    {
        if ($this->state->isEnabled()) {
            $enabled = $this->ansiFormat('ENABLED', Console::FG_RED);
            $datetime = $this->state->datetime();
            $this->stdout("Maintenance Mode has been $enabled\n");
            $this->stdout("on until $datetime\n");
            $this->stdout('Total (' . count($this->state->emails()) . ') followers.' . PHP_EOL);

            $this->stdout("\nMaintenance Mode update date and time.\n");
            $this->stdout("Use:\nphp yii maintenance/update \"$this->exampleData\"\nto update maintenance mode to $this->exampleData.\n");
            $this->stdout("Note:\nThis date and time not disable maintenance mode\n");

            $this->stdout("\nSubscribers to whom messages will be sent after turning off the mode maintenance\n");
            $this->stdout("Use:\nphp yii maintenance/followers\nto show followers.\n");

            $this->stdout("\nMaintenance Mode disable.\n");
            $this->stdout("Use:\nphp yii maintenance/disable\nto disable maintenance mode.\n");
        } else {
            $disabled = $this->ansiFormat('DISABLED', Console::FG_GREEN);
            $this->stdout("Maintenance Mode has been $disabled!\n");

            $this->stdout("\nMaintenance Mode enable.\n");
            $this->stdout("Use:\nphp yii maintenance/enable\nto enable maintenance mode.\n");

            $this->stdout("\nAlso maintenance Mode enable set to date and time.\n");
            $this->stdout("Use:\nphp yii maintenance/enable \"$this->exampleData\"\nto enable maintenance mode to $this->exampleData.\n");
            $this->stdout("Note:\nThis date and time not disable maintenance mode\n");

            $this->stdout("\nMaintenance Mode update date and time.\n");
            $this->stdout("Use:\nphp yii maintenance/update \"$this->exampleData\"\nto update maintenance mode to $this->exampleData.\n");
            $this->stdout("Note:\nThis date and time not disable maintenance mode\n");

            $this->stdout("\nSubscribers to whom messages will be sent after turning off the mode maintenance\n");
            $this->stdout("Use:\nphp yii maintenance/followers\nto show followers.\n");

            $this->stdout("\nMaintenance Mode disable.\n");
            $this->stdout("Use:\nphp yii maintenance/disable\nto disable maintenance mode.\n");
        }
    }

    /**
     * Enable maintenance mode
     * @param string $datetime
     */
    public function actionEnable($datetime = '')
    {
        if (!$this->state->isEnabled()) {
            $this->state->enable($datetime);
        }
        $datetime = $this->state->datetime();
        $enabled = $this->ansiFormat('ENABLED', Console::FG_RED);
        $this->stdout("Maintenance Mode has been $enabled\n");
        $this->stdout("on until $datetime\n");

        $this->stdout("\nMaintenance Mode update date and time.\n");
        $this->stdout("Use:\nphp yii maintenance/update \"$this->exampleData\"\nto update maintenance mode to $this->exampleData.\n");
        $this->stdout("Note:\nThis date and time not disable maintenance mode\n");

        $this->stdout("\nMaintenance Mode disable.\n");
        $this->stdout("Use:\nphp yii maintenance/disable\nto disable maintenance mode.\n");
    }

    /**
     * Update date and time maintenance mode
     * @param string $datetime dd-mm-Y H:i:s
     */
    public function actionUpdate($datetime = '')
    {
        if ($this->state->isEnabled()) {
            if ($this->state->validDate($datetime)) {
                $this->state->update($datetime);
                $updated = $this->ansiFormat('UPDATED', Console::FG_GREEN);
                $this->stdout("Maintenance Mode has been $updated!\n");
                $this->stdout("To: \n$datetime \n");
            } else {
                $this->stdout("Invalid date and time format\n");
                $this->stdout("Use:\nphp yii maintenance/update \"$this->exampleData\"\nto update maintenance mode to $this->exampleData.\n");
                $this->stdout("Note:\nThis date and time not disable maintenance mode\n");
            }
        } else {
            $this->stdout("Maintenance Mode not enable!\n");
            $this->stdout("Use:\nphp yii maintenance/enable\nto enable maintenance mode.\n");
            $this->stdout("\nAlso maintenance Mode enable set to date and time.\n");
            $this->stdout("Use:\nphp yii maintenance/enable \"$this->exampleData\"\nto enable maintenance mode to $this->exampleData.\n");
            $this->stdout("Note:\nThis date and time not disable maintenance mode\n");
        }
    }

    /**
     * Disable maintenance mode
     */
    public function actionDisable()
    {
        $this->state->disable();
        $this->stdout("Maintenance Mode has been disabled.\n");
        $this->stdout("Use:\nphp yii maintenance/enable\nto enable maintenance mode.\n");

        $this->stdout("\nAlso maintenance Mode enable set to date and time.\n");
        $this->stdout("Use:\nphp yii maintenance/enable \"$this->exampleData\"\nto enable maintenance mode to $this->exampleData.\n");
        $this->stdout("Note:\nThis date and time not disable maintenance mode\n");
    }

    /**
     * Show subscribers to whom messages
     */
    public function actionFollowers()
    {
        if ($emails = $this->state->emails()) {
            $this->stdout('Total (' . count($emails) . ') followers:' . PHP_EOL);
            foreach ($emails as $email) {
                $this->stdout($email . PHP_EOL);
            }
        }
    }

    /**
     * Example format date time
     * @return mixed
     */
    protected function exampleDateFormat()
    {
        return $this->state->datetime(time());
    }
}

