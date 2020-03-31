<?php
/**
 * This is the template for generating a trait within a module.
 */

/* @var $this yii\web\View */
/* @var $generator common\gii\generators\module\Generator */

require __DIR__ . '/base.php';

echo "<?php\n";
?>

namespace <?= $generator->getTraitNameSpace() ?>;

use Yii;
use <?= $ns ?>\<?= $className ?>;

/**
 * Trait <?= $className ?>Trait
 *
 * @property-read <?= $className ?> $module
 * @package <?= $generator->getTraitNameSpace() . "\n" ?>
 */
trait <?= $className ?>Trait
{
    /**
     * @return null|\yii\base\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('<?= $moduleName ?>');
    }
}
