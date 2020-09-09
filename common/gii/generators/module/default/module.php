<?php
/**
 * This is the template for generating a module class file.
 */

/* @var $this yii\web\View */
/* @var $generator common\gii\generators\module\Generator */

require __DIR__ . '/base.php';

echo "<?php\n";
?>

namespace <?= $ns ?>;

use Yii;
use yii\console\Application as ConsoleApplication;

/**
 * Class <?= $className . "\n" ?>
 * @package <?= $ns . "\n" ?>
 */
class <?= $className ?> extends \yii\base\Module
{
    public $controllerNamespace = '<?= $generator->getFrontendControllerNamespace() ?>';

    /**
     * @var bool If the module is used for the admin panel.
     */
    public $isBackend;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->isBackend === true) {
            $this->controllerNamespace = '<?= $generator->getBackendControllerNamespace() ?>';
            $this->setViewPath('@<?= $path ?>/views/backend');
        } else {
            $this->setViewPath('@<?= $path ?>/views/frontend');
        }
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = '<?= $generator->getConsoleControllerNamespace() ?>';
        }
    }

    /**
     * @param string $category
     * @param string $message
     * @param array $params
     * @param null|string $language
     * @return string
     */
    public static function translate($category, $message, $params = [], $language = null)
    {
        return Yii::t('<?= $path ?>/' . $category, $message, $params, $language);
    }
}
