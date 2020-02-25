<?php


namespace common\components\maintenance\actions\backend;

use Yii;
use yii\base\Action;
use common\components\maintenance\models\Manager;

/**
 * Class IndexAction
 * @package common\components\maintenance\actions
 *
 * @property array $viewRenderParams
 */
class IndexAction extends Action
{
    /** @var string */
    public $defaultName;

    /** @var string */
    public $layout;

    /** @var string */
    public $view;

    /** @var array */
    public $params = [];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if ($this->defaultName === null) {
            $this->defaultName = Yii::t('app', 'Maintenance');
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function run()
    {
        if ($this->layout !== null) {
            $this->controller->layout = $this->layout;
        }
        return $this->controller->render($this->view ?: $this->id, $this->getViewRenderParams());
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getViewRenderParams()
    {
        $model = new Manager();
        return [
            'name' => $this->defaultName,
            'model' => $model
        ];
    }
}
