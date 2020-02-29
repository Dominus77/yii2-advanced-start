<?php

namespace common\components\maintenance\actions\frontend;

use Yii;
use yii\base\Action;
use common\components\maintenance\interfaces\StateInterface;
use common\components\maintenance\states\FileState;
use common\components\maintenance\models\SubscribeForm;

/**
 * Class IndexAction
 * @package common\components\maintenance\actions\frontend
 *
 * @property array $viewRenderParams
 */
class IndexAction extends Action
{
    /** @var string */
    public $defaultName;

    /** @var string */
    public $defaultMessage;

    /** @var string */
    public $layout = 'maintenance';

    /** @var string */
    public $view;

    /** @var array */
    public $params = [];

    /**
     * @var StateInterface
     */
    protected $state;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->state = Yii::$container->get(StateInterface::class);

        if ($this->defaultMessage === null) {
            $this->defaultMessage = Yii::t('app', $this->state->getParams(FileState::MAINTENANCE_PARAM_CONTENT));
        }

        if ($this->defaultName === null) {
            $this->defaultName = Yii::t('app', $this->state->getParams(FileState::MAINTENANCE_PARAM_TITLE));
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
        $model = new SubscribeForm();
        return [
            'name' => $this->defaultName,
            'message' => $this->defaultMessage,
            'model' => $model,
        ];
    }
}
