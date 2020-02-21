<?php


namespace common\components\maintenance\actions;

use Yii;
use yii\base\Action;

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
            $this->defaultMessage = Yii::t('app', 'The site is undergoing technical work.');
        }

        if ($this->defaultName === null) {
            $this->defaultName = Yii::t('app', 'Maintenance');
        }
    }

    /**
     * @return string
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
     */
    protected function getViewRenderParams()
    {
        return [
            'name' => $this->defaultName,
            'message' => $this->defaultMessage,
        ];
    }
}
