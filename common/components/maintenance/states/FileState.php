<?php

namespace common\components\maintenance\states;

use Yii;
use DateTime;
use Generator;
use Exception;
use RuntimeException;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use common\components\maintenance\StateInterface;
use common\components\maintenance\models\SubscribeForm;

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
     * Enter Datetime format
     * @var string
     */
    public $dateFormat = 'd-m-Y H:i:s';

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
     */
    public function enable($datetime = '')
    {
        $date = new DateTime(date($this->dateFormat, strtotime('-1 day')));
        if ($this->validDate($datetime)) {
            $date = new DateTime($datetime);
        }
        $timestamp = $date->getTimestamp();
        $result = file_put_contents($this->path, $timestamp . PHP_EOL);
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
     * @throws Exception
     */
    public function update($replace, $line = 1)
    {
        $result = false;
        if ($replace && file_exists($this->path)) {
            if ($this->validDate($replace)) {
                $date = new DateTime($replace);
                $replace = $date->getTimestamp();
            }
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
     * @return mixed|void
     */
    public function disable()
    {
        try {
            if (file_exists($this->path)) {
                $subscribe = new SubscribeForm();
                $result = $subscribe->send($this->emails());
                unlink($this->path);
                return $result;
            }
        } catch (RuntimeException $e) {
            throw new RuntimeException(
                "Attention: the maintenance mode could not be disabled because {$this->path} could not be removed."
            );
        }
    }

    /**
     * Validate datetime
     *
     * @param $date
     * @return bool
     */
    public function validDate($date)
    {
        $d = DateTime::createFromFormat($this->dateFormat, $date);
        return $d && $d->format($this->dateFormat) === $date;
    }

    /**
     * Date ant Time
     *
     * @param string $format
     * @param string|integer $timestamp
     * @return string
     * @throws InvalidConfigException
     */
    public function datetime($timestamp = '', $format = '')
    {
        $format = $format ?: $this->dateFormat;
        $timestamp = $timestamp ?: $this->timestamp();
        return Yii::$app->formatter->asDatetime($timestamp, 'php:' . $format);
    }

    /**
     * Timestamp
     *
     * @return string
     */
    public function timestamp()
    {
        $contents = $this->getContentArray();
        if (isset($contents[0])) {
            return $contents[0];
        }
        return date($this->dateFormat, strtotime('-1 day'));
    }

    /**
     * Return emails to followers
     *
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
     *
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
     *
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
     *
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
     */
    protected function getStatusFilePath()
    {
        return Yii::getAlias($this->directory . '/' . $this->fileName);
    }
}
