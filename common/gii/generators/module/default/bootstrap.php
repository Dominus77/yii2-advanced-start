<?php
/**
 * This is the template for generating a bootstrap class file.
 */

/* @var $this yii\web\View */

require __DIR__ . '/base.php';

echo "<?php\n";
?>

namespace <?= $ns ?>;

use Yii;
use yii\i18n\PhpMessageSource;

/**
 * Class Bootstrap
 * @package <?= $ns ."\n" ?>
 */
class Bootstrap
{
    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['<?= $path ?>/*'] = [
            'class' => PhpMessageSource::class,
            'basePath' => '@<?= $path ?>/messages',
            'fileMap' => [
                '<?= $path ?>/module' => 'module.php'
            ]
        ];

        $urlManager = Yii::$app->urlManager;
        $urlManager->addRules(
            [
                '<?= $moduleName ?>' => '<?= $moduleName ?>/default/index',
                '<?= $moduleName ?>/<id:\d+>/<_a:[\w\-]+>' => '<?= $moduleName ?>/default/<_a>',
                '<?= $moduleName ?>/<_a:[\w\-]+>' => '<?= $moduleName ?>/default/<_a>'
            ]
        );
    }
}
