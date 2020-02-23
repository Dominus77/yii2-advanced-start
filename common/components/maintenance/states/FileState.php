<?php

namespace common\components\maintenance\states;

use Yii;
use common\components\maintenance\StateInterface;
use yii\base\BaseObject;

/**
 * Class FileState
 * @package common\components\maintenance\states
 *
 * @property bool|string $statusFilePath
 */
class FileState extends BaseObject implements StateInterface
{
    /**
     * @var string the filename that will determine if the maintenance mode is enabled
     */
    public $fileName = 'YII_MAINTENANCE_MODE_ENABLED';

    /**
     * @var string the directory in that the file stated in $fileName above is residing
     */
    public $directory = '@runtime';

    /**
     * @var string the complete path of the file - populated in init
     */
    public $path;

    /**
     * Initialization
     */
    public function init()
    {
        $this->path = $this->getStatusFilePath();
    }

    /**
     * Turn on mode.
     *
     * @since 0.2.5
     */
    public function enable()
    {
        if (file_put_contents($this->path,
                'The maintenance Mode of your Application is enabled if this file exists.' . PHP_EOL) === false) {
            throw new \Exception(
                "Attention: the maintenance mode could not be enabled because {$this->path} could not be created."
            );
        }
        chmod($this->path, 0775);
    }

    /**
     * Turn off mode.
     *
     * @since 0.2.5
     */
    public function disable()
    {
        if (file_exists($this->path)) {
            if (!unlink($this->path)) {
                throw new \Exception(
                    "Attention: the maintenance mode could not be disabled because {$this->path} could not be removed."
                );
            };
        }
    }

    /**
     * @return bool will return true if the file exists
     */
    public function isEnabled()
    {
        return file_exists($this->path);
    }

    /**
     * Return status file path.
     *
     * @return bool|string
     * @since 0.2.5
     */
    protected function getStatusFilePath()
    {
        return Yii::getAlias($this->directory . '/' . $this->fileName);
    }
}
