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
use yii\web\GroupUrlRule;

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
        $this->registerTranslations();
        $urlManager = Yii::$app->urlManager;
        $urlManager->addRules($this->getRules());
    }

    /**
     * Register Translations
     */
    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['<?= $path ?>/*'] = [
            'class' => PhpMessageSource::class,
            'basePath' => '@<?= $path ?>/messages',
            'fileMap' => [
                '<?= $path ?>/module' => 'module.php'
            ]
        ];
    }

    /**
     * @return GroupUrlRule[]
     */
    public function getRules()
    {
        return [
            new GroupUrlRule([
                'prefix' => '<?= $moduleName ?>',
                'rules' => [
                    '' => 'default/index',
                    '<id:\d+>/<_a:[\w\-]+>' => 'default/<_a>',
                    '<_a:[\w\-]+>' => 'default/<_a>'
                ]
            ])
        ];
    }
}
