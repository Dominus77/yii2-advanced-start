<?php

namespace modules\users\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\url;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $imageSize = [100 ,100];
    private $module;

    public function init()
    {
        parent::init();
        $this->module = Yii::$app->getModule('users');
        if($this->module->imageSize) {
            $this->imageSize = ArrayHelper::merge($this->module->imageSize, $this->imageSize);
        }
    }

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @param null $id
     * @return bool|string
     */
    public function upload($id = null)
    {
        $user_id = $id ? $id : Yii::$app->user->identity->getId();
        if ($this->validate()) {
            $model = User::findOne(['id' => $user_id]);

            if (!$model) {
                $model = new User();
                $model->id = $user_id;
            }

            $path = $this->getUserDirectory($model->id);
            $file = $this->imageFile;

            //удаляем старую аватарку
            if ($model->avatar) {
                $avatar = $path . '/' . $model->avatar;
                if (file_exists($avatar))
                    unlink($avatar);
            }


            $name = time() . '.' . $file->extension; //$file->imageFile->baseName
            $tmp = '_' . $name;
            if ($file->saveAs($path . '/' . $tmp)) {
                $model->avatar = $name;
                Image::thumbnail($path . '/' . $tmp, $this->imageSize[0], $this->imageSize[1])
                    ->save($path . '/' . $model->avatar, ['quality' => 80]);
                if (file_exists($path . '/' . $tmp))
                    unlink($path . '/' . $tmp);
                $model->save();
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $search
     * @param $replace
     * @param $text
     * @return mixed
     */
    private function str_replace_once($search, $replace, $text)
    {
        $pos = strpos($text, $search);
        return $pos !== false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getUserDirectory($user_id)
    {
        $upload = $this->module->uploads;
        $path = str_replace('\\', '/', Url::to('@upload') . DIRECTORY_SEPARATOR . $upload . DIRECTORY_SEPARATOR . $user_id);
        if (!file_exists($path)) {
            mkdir($path, 0700, true);
        }
        return $path;
    }
}