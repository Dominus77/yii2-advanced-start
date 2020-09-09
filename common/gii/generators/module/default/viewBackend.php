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

<div class="<?= $moduleName ?>-backend-default-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= '<?= Html::encode($this->title) ?>' ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>
            <p>
                This is the module <?= $moduleName ?> backend page.
                You may modify the following file to customize its content:
            </p>
            <code><?= '<?= __FILE__ ?>' ?></code>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
