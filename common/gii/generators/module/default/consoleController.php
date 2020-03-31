<?php
/**
 * This is the template for generating a console controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator common\gii\generators\module\Generator */

require __DIR__ . '/base.php';

echo "<?php\n";
?>

namespace <?= $generator->getControllerNamespace() ?>;

use yii\console\Controller;

/**
 * Class DefaultController
 * @package <?= $generator->getControllerNamespace() . "\n" ?>
 */
class DefaultController extends Controller
{
    /**
     * Console default actions
     * @inheritdoc
     */
    public function actionIndex()
    {
        echo 'php yii <?= $moduleName ?>/default' . PHP_EOL;
    }
}
