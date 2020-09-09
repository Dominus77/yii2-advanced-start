<?php
/* @var $this yii\web\View */
/* @var $generator common\gii\generators\module\Generator */

require __DIR__ . '/base.php';

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $ns ?>\<?= $className ?>;

$this->title = <?= $className ?>::translate('module', '<?= ucfirst($moduleName) ?>');
$this->params['breadcrumbs'][] = $this->title;
<?= '?>' ?>

<div class="<?= $moduleName ?>-frontend-default-index">
    <h1><?='<?= Html::decode($this->title) ?>' ?></h1>

    <p>
        This is the module <?= $moduleName ?> frontend page.
        You may modify the following file to customize its content:
    </p>

    <code><?= '<?= __FILE__ ?>' ?></code>
</div>
