<?php


namespace common\components\maintenance\actions;

use Yii;
use yii\base\Action;
use DateTime;

/**
 * Class MaintenanceAction
 * @package common\components\maintenance\actions
 *
 * @property array $viewRenderParams
 */
class MaintenanceAction extends Action
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
     * {@inheritdoc}
     */
    public function init()
    {
        if ($this->defaultMessage === null) {
            $this->defaultMessage = Yii::t('app', 'The site is undergoing technical work. We apologize for any inconvenience caused.');
        }

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
        return [
            'name' => $this->defaultName,
            'message' => $this->defaultMessage
        ];
    }
}
