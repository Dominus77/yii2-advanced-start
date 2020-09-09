<?php

namespace modules\users\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Image\ImageInterface;
use modules\users\Module;

/**
 * Class UploadForm
 * @package modules\users\models
 */
class UploadForm extends Model
{
    const PREFIX_ORIGINAL = 'original_';
    const PREFIX_THUMBNAIL = 'thumb_';
    const EXTENSIONS = 'png, jpg';

    /**
     * @var UploadedFile
     */
    public $imageFile;
    /**
     * Upload directory
     * @var string
     */
    public $directory = '@frontend/runtime/avatars';
    /**
     * File Name
     * @var string
     */
    public $fileName = 'avatar';
    /**
     * File extension
     * @var string
     */
    public $fileExtension = 'jpg';
    /**
     * @var null|int
     */
    public $width = 540;
    /**
     * @var null|int
     */
    public $height;
    /**
     * @var int
     */
    public $avatarWidth = 150;
    /**
     * @var int
     */
    public $avatarHeight = 150;
    /**
     * @var int
     */
    public $avatarQuality = 100;
    /**
     * @var int
     */
    public $cropWidth;
    /**
     * @var int
     */
    public $cropHeight;
    /**
     * @var int
     */
    public $cropX;
    /**
     * @var int
     */
    public $cropY;
    /**
     * @var int
     */
    public $quality = 80;

    /**
     * @var int
     */
    public $cropQuality = 100;

    /**
     * Upload path
     * @var string|bool
     */
    private $path = '';

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->path = $this->path ?: $this->getPath(Yii::$app->user->id);
    }

    /**
     * Rules
     * @inheritDoc
     * @return array|array[]
     */
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => self::EXTENSIONS],
            [['cropWidth', 'cropHeight', 'cropX', 'cropY'], 'integer']
        ];
    }

    /**
     * Labels
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'imageFile' => Module::translate('module', 'Image'),
            'cropWidth' => Module::translate('module', 'Crop Width'),
            'cropHeight' => Module::translate('module', 'Crop Height'),
            'cropX' => Module::translate('module', 'Crop X'),
            'cropY' => Module::translate('module', 'Crop Y'),
        ];
    }

    /**
     * Upload
     * @return array|string
     * @throws Exception
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->createDirectory();

            $fileName = $this->getFileName();
            $path = $this->path . DIRECTORY_SEPARATOR . self::PREFIX_ORIGINAL . $fileName;
            if ($this->imageFile->saveAs($path)) {
                $this->resize();
                $this->delete($path);
                return $this->path . DIRECTORY_SEPARATOR . self::PREFIX_THUMBNAIL . $fileName;
            }
        }
        return $this->errors;
    }

    /**
     * File Name
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName . '.' . $this->fileExtension;
    }

    /**
     * Resize
     * @param $width int
     * @param $height int
     * @return ImageInterface
     */
    public function resize($width = null, $height = null)
    {
        $tWidth = $width ?: $this->width;
        $tHeight = $height ?: $this->height;
        $fileName = $this->getFileName();
        $path = $this->path . DIRECTORY_SEPARATOR . self::PREFIX_ORIGINAL . $fileName;
        $thumbPath = $this->path . DIRECTORY_SEPARATOR . self::PREFIX_THUMBNAIL . $fileName;
        return Image::resize($path, $tWidth, $tHeight)->save($thumbPath, ['quality' => $this->quality]);
    }

    /**
     * Crop
     * Обрежет по ширине на 150px, по высоте на 150px, начиная по оси X с отметки в 100px и по оси Y с отметки в 100px
     * @return ImageInterface
     */
    public function crop()
    {
        $fileName = $this->getFileName();
        $thumbPath = $this->path . DIRECTORY_SEPARATOR . self::PREFIX_THUMBNAIL . $fileName;
        $path = $this->path . DIRECTORY_SEPARATOR . $fileName;
        Image::crop($thumbPath, $this->cropWidth, $this->cropHeight, [$this->cropX, $this->cropY])
            ->save($path, ['quality' => $this->cropQuality]);
        return Image::thumbnail(
            $path,
            $this->avatarWidth,
            $this->avatarHeight
        )->save($path, ['quality' => $this->avatarQuality]);
    }

    /**
     * @param int|string $id
     * @return bool
     */
    public function isThumbFile($id)
    {
        $fileName = $this->getFileName();
        $path = $this->getPath($id) . DIRECTORY_SEPARATOR . self::PREFIX_THUMBNAIL . $fileName;
        if (file_exists($path)) {
            return true;
        }
        return false;
    }

    /**
     * Delete file
     * @param string|array $path
     * @return bool
     */
    public function delete($path)
    {
        if (is_array($path)) {
            foreach ($path as $item) {
                if (file_exists($item)) {
                    FileHelper::unlink($item);
                }
            }
        } elseif (file_exists($path)) {
            FileHelper::unlink($path);
        }
        return true;
    }

    /**
     * @param int|string $id
     * @return string
     */
    public function getPath($id)
    {
        $this->path = Yii::getAlias($this->directory . '/' . $id);
        return (string)$this->path;
    }

    /**
     * Create directory
     * @return bool
     * @throws Exception
     */
    public function createDirectory()
    {
        return FileHelper::createDirectory($this->path, 0777);
    }
}
