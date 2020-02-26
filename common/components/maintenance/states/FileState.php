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
use yii\helpers\ArrayHelper;

/**
 * Class FileState
 * @package common\components\maintenance\states
 *
 * @property bool|string $filePath
 * @property array $contentArray
 * @property array $maintenanceFileLinesParamsArray
 * @property bool $validDate
 */
class FileState extends BaseObject implements StateInterface
{

    const MAINTENANCE_PARAM_TIMESTAMP = 'timestamp';
    const MAINTENANCE_PARAM_TITLE = 'title';
    const MAINTENANCE_PARAM_CONTENT = 'content';
    const MAINTENANCE_PARAM_SUBSCRIBE = 'subscribe';

    const MAINTENANCE_SUBSCRIBE_ON = 'true';
    const MAINTENANCE_SUBSCRIBE_OFF = 'false';

    /**
     * @var string the filename that will determine if the maintenance mode is enabled
     */
    public $fileName = 'YII_MAINTENANCE_MODE_ENABLED';

    /**
     * Default title
     * @var string
     */
    public $defaultTitle = 'Maintenance';

    /**
     * Default content
     * @var string
     */
    public $defaultContent = 'The site is undergoing technical work. We apologize for any inconvenience caused.';

    /**
     * @var string name of the file where subscribers will be stored
     */
    public $fileSubscribe = 'YII_MAINTENANCE_MODE_SUBSCRIBE';

    /**
     * Set status subscribe
     * @var string
     */
    public $subscribe;

    /**
     * @var string the directory in that the file stated in $fileName above is residing
     */
    public $directory = '@runtime';

    /**
     * @var string the complete path of the file - populated in init
     */
    public $path;

    /**
     * @var string the complete path of the file subscribe - populated in init
     */
    public $subscribePath;

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
        $this->path = $this->getFilePath($this->fileName);
        $this->subscribePath = $this->getFilePath($this->fileSubscribe);
        $this->subscribe = $this->subscribe ?: self::MAINTENANCE_SUBSCRIBE_ON;
    }

    /**
     * Turn on mode.
     *
     * @param string $datetime
     * @param string $title
     * @param string $content
     * @param string $subscribe
     * @return mixed|void
     * @throws Exception
     */
    public function enable($datetime = '', $title = '', $content = '', $subscribe = '')
    {
        $date = new DateTime(date($this->dateFormat));
        if ($this->validDate($datetime)) {
            $date = new DateTime($datetime);
        }
        $timestamp = $date->getTimestamp();

        $title = $title ?: Yii::t('app', $this->defaultTitle);
        $content = $content ?: Yii::t('app', $this->defaultContent);
        $subscribe = $subscribe ?: $this->subscribe;

        $data = $timestamp . PHP_EOL . $title . PHP_EOL . $content . PHP_EOL . $subscribe . PHP_EOL;
        $result = file_put_contents($this->path, $data);
        chmod($this->path, 0765);

        if ($result === false) {
            throw new RuntimeException(
                "Attention: the maintenance mode could not be enabled because {$this->path} could not be created."
            );
        }
    }

    /**
     * Update param in maintenance file
     * @param string $param
     * @param string $value
     * @return bool
     * @throws Exception
     */
    public function updateParam($param = '', $value = '')
    {
        switch ($param) {
            case self::MAINTENANCE_PARAM_TIMESTAMP:
                if ($this->validDate($value)) {
                    $date = new DateTime($value);
                    $this->update($date->getTimestamp(), $this->getLine(self::MAINTENANCE_PARAM_TIMESTAMP));
                }
                break;
            case self::MAINTENANCE_PARAM_TITLE:
                $this->update($value, $this->getLine(self::MAINTENANCE_PARAM_TITLE));
                break;
            case self::MAINTENANCE_PARAM_CONTENT:
                $this->update($value, $this->getLine(self::MAINTENANCE_PARAM_CONTENT));
                break;
            case self::MAINTENANCE_PARAM_SUBSCRIBE:
                $this->update($value, $this->getLine(self::MAINTENANCE_PARAM_SUBSCRIBE));
                break;
            default:
                return false;
        }
        return true;
    }

    /**
     * File Line Param
     * @param $param
     * @return mixed
     */
    public function getLine($param)
    {
        return ArrayHelper::getValue(array_flip($this->getMaintenanceFileLinesParamsArray()), $param);
    }

    /**
     * File Lines Params
     * @return array
     */
    protected function getMaintenanceFileLinesParamsArray()
    {
        return [
            1 => self::MAINTENANCE_PARAM_TIMESTAMP,
            2 => self::MAINTENANCE_PARAM_TITLE,
            3 => self::MAINTENANCE_PARAM_CONTENT,
            4 => self::MAINTENANCE_PARAM_SUBSCRIBE
        ];
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
                if ($result > 0) {
                    unlink($this->subscribePath);
                }
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
        return $this->getParams(self::MAINTENANCE_PARAM_TIMESTAMP);
    }

    /**
     * Save email in file
     *
     * @param string $str
     * @param string $file
     * @return bool
     */
    public function save($str, $file)
    {
        try {
            if ($str && $file) {
                $fp = fopen($file, 'ab');
                fwrite($fp, $str . PHP_EOL);
                fclose($fp);
                return chmod($file, 0765);
            }
            return false;
        } catch (RuntimeException $e) {
            throw new RuntimeException(
                "Attention: Subscriber cannot be added because {$file} could not be save."
            );
        }
    }

    /**
     * Get params this maintenance file
     * @param string $param
     * @return array|false|mixed|string
     */
    public function getParams($param = '')
    {
        $content = $this->getContentArray($this->path);
        if ($param) {
            switch ($param) {
                case self::MAINTENANCE_PARAM_TIMESTAMP:
                    $value = isset($content[0]) ? $content[0] : date($this->dateFormat);
                    break;
                case self::MAINTENANCE_PARAM_TITLE:
                    $value = isset($content[1]) ? $content[1] : '';
                    break;
                case self::MAINTENANCE_PARAM_CONTENT:
                    $value = isset($content[2]) ? $content[2] : '';
                    break;
                case self::MAINTENANCE_PARAM_SUBSCRIBE:
                    $value = isset($content[3]) ? $content[3] : '';
                    break;
                default:
                    $value = '';
            }
            return $value;
        }
        return $content;
    }

    /**
     * Return emails to followers
     *
     * @return array
     */
    public function emails()
    {
        $contents = $this->getContentArray($this->subscribePath);
        sort($contents);
        return $contents;
    }

    /**
     * Return content to array this file
     *
     * @param $file string
     * @return array
     */
    protected function getContentArray($file)
    {
        $contents = $this->readTheFile($file);
        $items = [];
        foreach ($contents as $key => $item) {
            $items[] = $item;
        }
        return array_filter($items);
    }

    /**
     * Read file
     *
     * @param $file string
     * @return Generator
     */
    protected function readTheFile($file)
    {
        try {
            if (file_exists($file)) {
                $handle = fopen($file, 'rb');
                while (!feof($handle)) {
                    yield trim(fgets($handle));
                }
                fclose($handle);
            }
        } catch (RuntimeException $e) {
            throw new RuntimeException(
                "Failed to read $file file"
            );
        }
    }

    /**
     * Create file
     *
     * @param $file string
     */
    protected function createFile($file)
    {
        try {
            if ($file && !file_exists($file)) {
                file_put_contents($file, '');
                chmod($file, 0765);
            }
        } catch (RuntimeException $e) {
            throw new RuntimeException(
                "Failed to create $file file."
            );
        }
    }

    /**
     * @return bool will return true if on subscribe
     */
    public function isSubscribe()
    {
        $param = $this->getParams(self::MAINTENANCE_PARAM_SUBSCRIBE);
        return $param === 'true';
    }

    /**
     * @return bool will return true if the file exists
     */
    public function isEnabled()
    {
        return file_exists($this->path);
    }

    /**
     * Return file path.
     *
     * @param $fileName string
     * @return bool|string
     */
    protected function getFilePath($fileName)
    {
        return Yii::getAlias($this->directory . '/' . $fileName);
    }
}
