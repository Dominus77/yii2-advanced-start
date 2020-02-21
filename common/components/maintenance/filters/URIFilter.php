<?php

namespace common\components\maintenance\filters;

use Yii;
use common\components\maintenance\Filter;
use yii\helpers\VarDumper;
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
     * URIChecker constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->request = Yii::$app->request;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (is_string($this->uri)) {
            $this->uri = [$this->uri];
        }
    }

    /**
     * @return bool
     * @throws \yii\console\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function isAllowed()
    {
        if (is_array($this->uri) && !empty($this->uri) && $resolve = $this->request->resolve()) {
            return (bool)in_array($resolve[0], $this->uri, true);
        }
        return false;
    }
}
