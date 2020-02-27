<?php

namespace common\components\maintenance\commands;

use yii\helpers\Console;
use yii\console\Controller;
use yii\base\Module;
use common\components\maintenance\interfaces\StateInterface;
use common\components\maintenance\states\FileState;

/**
 * Maintenance mode
 * @package common\components\maintenance\commands
 */
class MaintenanceController extends Controller
{
    /**
     * Date
     * @var string
     */
    public $date;
    /**
     * Title
     * @var string
     */
    public $title;
    /**
     * Content
     * @var string
     */
    public $content;
    /**
     * @var string
     */
    public $subscribe;

    /**
     * @var StateInterface
     */
    protected $state;
    /**
     * @var mixed string
     */
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
     * Options
     * @param string $actionID
     * @return array|string[]
     */
    public function options($actionID)
    {
        return [
            'date',
            'title',
            'content',
            'subscribe',
        ];
    }

    /**
     * Aliases
     * @return array
     */
    public function optionAliases()
    {
        return [
            'd' => 'date',
            't' => 'title',
            'c' => 'content',
            's' => 'subscribe'
        ];
    }

    /**
     * Maintenance status or commands
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
            $this->stdout("Use:\nphp yii maintenance/update --date=\"$this->exampleData\"\nto update maintenance mode to $this->exampleData.\n");
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
            $this->stdout("Use:\nphp yii maintenance/enable --date=\"$this->exampleData\"\nto enable maintenance mode to $this->exampleData.\n");
            $this->stdout("Note:\nThis date and time not disable maintenance mode\n");

            $this->stdout("\nMaintenance Mode update date and time.\n");
            $this->stdout("Use:\nphp yii maintenance/update --date=\"$this->exampleData\"\nto update maintenance mode to $this->exampleData.\n");
            $this->stdout("Note:\nThis date and time not disable maintenance mode\n");

            $this->stdout("\nSubscribers to whom messages will be sent after turning off the mode maintenance\n");
            $this->stdout("Use:\nphp yii maintenance/followers\nto show followers.\n");

            $this->stdout("\nMaintenance Mode disable.\n");
            $this->stdout("Use:\nphp yii maintenance/disable\nto disable maintenance mode.\n");
        }
    }

    /**
     * Enable maintenance mode
     */
    public function actionEnable()
    {
        $datetime = $this->date;
        if (!$this->state->isEnabled()) {
            $this->state->enable($datetime, $this->title, $this->content, $this->subscribe);
        }
        $datetime = $this->state->datetime();
        $enabled = $this->ansiFormat('ENABLED', Console::FG_RED);
        $this->stdout("Maintenance Mode has been $enabled\n");
        $this->stdout("on until $datetime\n");

        $this->stdout("\nMaintenance Mode update date and time.\n");
        $this->stdout("Use:\nphp yii maintenance/update --date=\"$this->exampleData\"\nto update maintenance mode to $this->exampleData.\n");
        $this->stdout("Note:\nThis date and time not disable maintenance mode\n");

        $this->stdout("\nSubscribers to whom messages will be sent after turning off the mode maintenance\n");
        $this->stdout("Use:\nphp yii maintenance/followers\nto show followers.\n");

        $this->stdout("\nMaintenance Mode disable.\n");
        $this->stdout("Use:\nphp yii maintenance/disable\nto disable maintenance mode.\n");
    }

    /**
     * Update date and time maintenance mode
     */
    public function actionUpdate()
    {
        if ($this->state->isEnabled()) {
            $status = false;
            $updated = $this->ansiFormat('UPDATED', Console::FG_GREEN);
            if ($this->date) {
                if ($this->state->validDate($this->date)) {
                    $this->state->update(FileState::MAINTENANCE_PARAM_DATE, $this->date);
                    $param = $this->state->datetime();
                    $this->stdout("Maintenance Mode has been $updated!\n");
                    $this->stdout("To: $param\n");
                    $status = true;
                } else {
                    $this->stdout("Invalid date and time format\n");
                    $this->stdout("Use:\nphp yii maintenance/update --date=\"$this->exampleData\"\nto update maintenance mode to $this->exampleData.\n");
                    $this->stdout("Note:\nThis date and time not disable maintenance mode\n");
                    $status = true;
                }
            }

            if ($this->title) {
                $this->state->update(FileState::MAINTENANCE_PARAM_TITLE, $this->title);
                $param = $this->state->getParams(FileState::MAINTENANCE_PARAM_TITLE);
                $this->stdout("Maintenance Mode has been $updated!\n");
                $this->stdout("To: $param\n");
                $status = true;
            }

            if ($this->content) {
                $this->state->update(FileState::MAINTENANCE_PARAM_CONTENT, $this->content);
                $param = $this->state->getParams(FileState::MAINTENANCE_PARAM_CONTENT);
                $this->stdout("Maintenance Mode has been $updated!\n");
                $this->stdout("To: $param\n");
                $status = true;
            }

            if ($this->subscribe) {
                $this->state->update(FileState::MAINTENANCE_PARAM_SUBSCRIBE, $this->subscribe);
                $param = $this->state->getParams(FileState::MAINTENANCE_PARAM_SUBSCRIBE);
                $this->stdout("Maintenance Mode has been $updated!\n");
                $this->stdout("To: $param\n");
                $status = true;
            }

            if ($status === false) {
                $this->stdout("Not specified what to update\n");
                $this->stdout("\nUse:\n");
                $this->stdout("\nphp yii maintenance/update --date=\"$this->exampleData\"\nto update maintenance mode to $this->exampleData.\n");
                $this->stdout("\nphp yii maintenance/update --title=\"Maintenance\"\nto update maintenance mode title.\n");
                $this->stdout("\nphp yii maintenance/update --content=\"Maintenance\"\nto update maintenance mode text content.\n");
                $this->stdout("\nphp yii maintenance/update --subscribe=true\nto enable subscribe form for maintenance mode.\n");
            }
        } else {
            $this->stdout("Maintenance Mode not enable!\n");

            $this->stdout("Use:\nphp yii maintenance/enable\nto enable maintenance mode.\n");

            $this->stdout("\nAlso maintenance Mode enable set to date and time.\n");
            $this->stdout("Use:\nphp yii maintenance/enable --date=\"$this->exampleData\"\nto enable maintenance mode to $this->exampleData.\n");
            $this->stdout("Note:\nThis date and time not disable maintenance mode\n");
        }
    }

    /**
     * Disable maintenance mode
     */
    public function actionDisable()
    {
        $result = $this->state->disable();
        $this->stdout("Maintenance Mode has been disabled.\n");
        if ($result || $result === 0) {
            $this->stdout("Notified ($result) subscribers.\n");
        }

        $this->stdout("\nUse:\nphp yii maintenance/enable\nto enable maintenance mode.\n");

        $this->stdout("\nAlso maintenance Mode enable set to date and time.\n");
        $this->stdout("Use:\nphp yii maintenance/enable --date=\"$this->exampleData\"\nto enable maintenance mode to $this->exampleData.\n");
        $this->stdout("Note:\nThis date and time not disable maintenance mode\n");
    }

    /**
     * Show subscribers to whom messages
     */
    public function actionFollowers()
    {
        if (!$this->state->isEnabled()) {
            $this->stdout("Maintenance Mode not enable!\n");

            $this->stdout("\nUse:\nphp yii maintenance/enable\nto enable maintenance mode.\n");

            $this->stdout("\nAlso maintenance Mode enable set to date and time.\n");
            $this->stdout("Use:\nphp yii maintenance/enable --date=\"$this->exampleData\"\nto enable maintenance mode to $this->exampleData.\n");
            $this->stdout("Note:\nThis date and time not disable maintenance mode\n");
        } else if ($emails = $this->state->emails()) {
            $this->stdout('Total (' . count($emails) . ') followers:' . PHP_EOL);
            foreach ($emails as $email) {
                $this->stdout($email . PHP_EOL);
            }
        } else {
            $this->stdout("No followers\n");
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

