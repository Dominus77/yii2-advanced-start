<?php
/**
 * This is the template for generating a frontend controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use yii\web\Controller;

/**
 * Class DefaultController
 * @package <?= $generator->getControllerNamespace() . "\n"?>
 */
class DefaultController extends Controller
{
    /**
     * Displays index page.
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
