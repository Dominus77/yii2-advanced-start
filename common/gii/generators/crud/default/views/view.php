<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= "<?= " ?>Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="pull-right">
                <p>
                    <?= "<?= " ?>Html::a(
                        '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' .
                        <?= $generator->generateString('Update') ?>,
                        ['update', <?= $urlParams ?>],
                        ['class' => 'btn btn-primary']
                    ) ?>
                    <?= "<?= " ?>Html::a(
                        '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ' .
                        <?= $generator->generateString('Delete') ?>,
                        ['delete', <?= $urlParams ?>],
                        [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                                'method' => 'post',
                            ],
                        ]
                    ) ?>
                </p>
            </div>
            <?= "<?= " ?>DetailView::widget([
                'model' => $model,
                'attributes' => [
                <?php if (($tableSchema = $generator->getTableSchema()) === false) {
                    echo "\r";
                    foreach ($generator->getColumnNames() as $name) {
                        echo "                    '" . $name . "',\n";
                    }
                } else {
                    echo "\r";
                    foreach ($generator->getTableSchema()->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                        echo "                    '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                } ?>
                ],
            ]) ?>
        </div>
    </div>
</div>
