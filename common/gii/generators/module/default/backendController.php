<?php
/**
 * This is the template for generating a backend controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use yii\web\Controller;
use yii\filters\AccessControl;
use modules\rbac\models\Permission;

/**
 * Class DefaultController
 * @package <?= $generator->getControllerNamespace() . "\n"?>
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Permission::PERMISSION_VIEW_ADMIN_PAGE]
                    ]
                ]
            ]
        ];
    }

    /**
     * Displays index page.
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
