<?php

namespace common\components\maintenance\filters;

use Yii;
use common\components\maintenance\Filter;
use yii\web\NotFoundHttpException;
use yii\web\Request;

/**
 * Class URIFilter
 * @package common\components\maintenance\filters
 */
class URIFilter extends Filter
{
    /**
     * @var array
     */
    public $uri;
    /**
     * @var Request
     */
    protected $request;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->request = Yii::$app->request;
        if (is_string($this->uri)) {
            $this->uri = [$this->uri];
        }
    }

    /**
     * @return bool
     * @throws NotFoundHttpException
     */
    public function isAllowed()
    {
        if (is_array($this->uri) && !empty($this->uri) && $resolve = $this->request->resolve()) {
            return (bool)in_array($resolve[0], $this->uri, true);
        }
        return false;
    }
}
