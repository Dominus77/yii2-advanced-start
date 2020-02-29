<?php


namespace common\components\maintenance\actions\backend;

use Yii;
use yii\base\Action;
use common\components\maintenance\models\FileStateForm;
use yii\data\ArrayDataProvider;

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
            $this->defaultName = Yii::t('app', 'Mode site');
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
        $model = new FileStateForm();
        if (($post = Yii::$app->request->post()) && $model->load($post) && $model->validate() && $model->save()) {
            return $this->controller->refresh();
        }

        return $this->controller->render($this->view ?: $this->id, $this->getViewRenderParams($model));
    }

    /**
     * @param $model FileStateForm
     * @return array
     */
    protected function getViewRenderParams($model)
    {
        $listDataProvider = new ArrayDataProvider([
            'allModels' => array_flip($model->followers),
            'pagination' => [
                'pageSize' => 18
            ],
        ]);

        return [
            'name' => $this->defaultName,
            'model' => $model,
            'isEnable' => $model->isEnabled(),
            'listDataProvider' => $listDataProvider
        ];
    }
}
