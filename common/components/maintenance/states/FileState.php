<?php

namespace common\components\maintenance\states;

use Yii;
use common\components\maintenance\StateInterface;
use yii\base\BaseObject;
use DateTime;
use Generator;
use RuntimeException;
use Exception;

/**
 * Class FileState
 * @package common\components\maintenance\states
 *
 * @property bool|string $statusFilePath
 * @property array $contentArray
 * @property bool $validDate
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
     * @var string
     */
    public $format = 'd-m-Y H:i:s';

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
     * @param string $datetime
     * @throws Exception
     * @since 0.2.5
     */
    public function enable($datetime = '')
    {
        $datetime = !empty($datetime) ? $datetime : date($this->format);
        $result = file_put_contents($this->path, $datetime . PHP_EOL);
        chmod($this->path, 0765);
        if ($result === false) {
            throw new RuntimeException(
                "Attention: the maintenance mode could not be enabled because {$this->path} could not be created."
            );
        }
    }

    /**
     * Update text to mode file
     *
     * @param string $replace
     * @param int $line
     * @return mixed|void
     */
    public function update($replace, $line = 1)
    {
        $result = false;
        if ($replace && file_exists($this->path)) {
            $file = file($this->path);
            $file[$line - 1] = $replace . PHP_EOL;
            $result = file_put_contents($this->path, implode('', $file));
        }
        if ($result === false) {
            throw new RuntimeException(
                "Attention: failed to update the end date of the maintenance mode, because {$this->path} failed to update."
            );
        }
    }

    /**
     * Turn off mode.
     *
     * @since 0.2.5
     */
    public function disable()
    {
        if (file_exists($this->path) && !unlink($this->path)) {
            throw new RuntimeException(
                "Attention: the maintenance mode could not be disabled because {$this->path} could not be removed."
            );
        }
    }

    /**
     * Check validate date
     * @param $date
     * @return bool
     */
    public function validDate($date)
    {
        $d = DateTime::createFromFormat($this->format, $date);
        return $d && $d->format($this->format) === $date;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function timestamp()
    {
        $date = new DateTime($this->datetime());
        return $date->getTimestamp();
    }

    /**
     * Date and Time
     * @return string
     */
    public function datetime()
    {
        $contents = $this->getContentArray();
        if (isset($contents[0]) && $this->validDate($contents[0])) {
            return $contents[0];
        }
        return date($this->format, strtotime('-1 day'));
    }

    /**
     * Return emails to subscribe
     * @return array
     */
    public function emails()
    {
        $contents = $this->getContentArray();
        unset($contents[0]);
        sort($contents);
        return $contents;
    }

    /**
     * Save email in file
     * @param string $str
     * @return bool
     */
    public function save($str)
    {
        if ($str) {
            $fp = fopen($this->path, 'ab');
            fwrite($fp, $str . PHP_EOL);
            fclose($fp);
            return true;
        }
        return false;
    }

    /**
     * Return content to array this file
     * @return array
     */
    protected function getContentArray()
    {
        $contents = $this->readTheFile();
        $items = [];
        foreach ($contents as $key => $item) {
            $items[] = $item;
        }
        return array_filter($items);
    }

    /**
     * Read file
     * @return Generator
     */
    protected function readTheFile()
    {
        $handle = fopen($this->path, 'rb');
        while (!feof($handle)) {
            yield trim(fgets($handle));
        }
        fclose($handle);
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
