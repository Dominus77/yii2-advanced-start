<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?php if ($generator->indexWidgetType === 'grid') : ?>
use yii\widgets\LinkPager;
<?php endif; ?>
<?= $generator->enablePjax ? "use yii\widgets\Pjax;\r\n" : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= "<?= " ?>Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right"></div>
        </div>
<?= $generator->enablePjax ? "        <?php Pjax::begin(); ?>\n" : '' ?>
        <div class="box-body">
            <?php if (!empty($generator->searchModelClass)) : ?>
<?= "<?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php endif; ?>
            <?php if (($generator->indexWidgetType === 'grid') && $generator->enablePageSize) : ?>

            <div class="pull-left">
                <?= "<?= " ?>common\widgets\PageSize::widget([
                    'label' => '',
                    'defaultPageSize' => 25,
                    'sizes' => [10 => 10, 15 => 15, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 200 => 200],
                    'options' => [
                        'class' => 'form-control'
                    ]
                ])<?= " ?>\r" ?>
            </div>
            <?php endif; ?><?= "\r" ?>
            <div class="pull-right">
                <p>
                    <?= "<?= " ?>Html::a('<span class="fa fa-plus"></span>', ['create'], [
                        'class' => 'btn btn-block btn-success',
                        'title' => 'Create',
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'left',
                            'pjax' => 0
                        ]
                    ]) ?>
                </p>
            </div>
<?php if ($generator->indexWidgetType === 'grid') : ?>
            <?= "<?= " ?>GridView::widget([
                'dataProvider' => $dataProvider,
                <?php if (!empty($generator->searchModelClass)) {
                    echo "'filterModel' => \$searchModel,\n";
                    if($generator->enablePageSize) {
                        echo "                'filterSelector' => 'select[name=\"per-page\"]',\n";
                    }
                } else {
                    echo "'filterSelector' => 'select[name=\"per-page\"]',\n";
                }?>
                'layout' => "{items}",
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
    <?php
    echo "\r";
    $count = 0;
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $name) {
            if (++$count < 6) {
                echo "                    '" . $name . "',\n";
            } else {
                echo "                    //'" . $name . "',\n";
            }
        }
    } else {
        foreach ($tableSchema->columns as $column) {
            $format = $generator->generateColumnFormat($column);
            if (++$count < 6) {
                echo "                    '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            } else {
                echo "                    //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        }
    }
    ?>

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]) ?>
<?php else : ?>
            <?= "<?= " ?>ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                    return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                },
            ]) ?>
<?php endif; ?>
        </div>
        <?php if ($generator->indexWidgetType === 'grid') : ?>
<div class="box-footer">
            <?= "<?= " ?>LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'registerLinkTags' => true,
                'options' => [
                    'class' => 'pagination pagination-sm no-margin pull-right',
                ]
            ])<?= " ?>\r"?>
        </div>
        <?php endif; ?>
<?= $generator->enablePjax ? "<?php Pjax::end(); ?>\n" : "\r" ?>
    </div>
</div>
