<?php

use modules\main\Module;
use backend\widgets\box\SmallBox;
use backend\widgets\chart\morris\Area as MorrisArea;
use backend\widgets\chart\morris\Donut as MorrisDonut;
use backend\widgets\chart\morris\Line as MorrisLine;
use backend\widgets\chart\morris\Bar as MorrisBar;

/* @var $this yii\web\View */

$this->title = Module::translate('module', 'Home');
$this->params['title']['small'] = Module::translate('module', 'Dashboard');
?>

<section class="main-backend-default-index">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_AQUA,
                'icon' => 'ion-bag',
                'header' => 150,
                'content' => 'New Orders',
                'link' => ['label' => 'More info <i class="fa fa-arrow-circle-right"></i>', 'url' => ['#']]
            ]) ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_GREEN,
                'icon' => 'ion-stats-bars',
                'header' => '53<sup style="font-size: 20px">%</sup>',
                'content' => 'Bounce Rate',
                'link' => ['label' => 'More info <i class="fa fa-arrow-circle-right"></i>', 'url' => ['#']]
            ]) ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_YELLOW,
                'icon' => 'ion-person-add',
                'header' => 44,
                'content' => 'User Registrations',
                'link' => ['label' => 'More info <i class="fa fa-arrow-circle-right"></i>', 'url' => ['#']]
            ]) ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_RED,
                'icon' => 'ion-pie-graph',
                'header' => 65,
                'content' => 'Unique Visitors',
                'link' => ['label' => 'More info <i class="fa fa-arrow-circle-right"></i>', 'url' => ['#']]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <section class="col-lg-7 connectedSortable">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                    <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
                    <li><a href="#line-chart" data-toggle="tab">Line</a></li>
                    <li><a href="#bar-chart" data-toggle="tab">Bar</a></li>
                    <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
                </ul>

                <div class="tab-content no-padding">
                    <div id="revenue-chart" class="chart tab-pane active">
                        <?= MorrisArea::widget([
                            'status' => true,
                            'clientOptions' => [
                                'xkey' => 'y',
                                'ykeys' => ['item1', 'item2'],
                                'labels' => ['Value 1', 'Value 2'],
                                'lineColors' => ['#a0d0e0', '#3c8dbc'],
                                'data' => [
                                    ['y' => '2018 Q1', 'item1' => 2666, 'item2' => 2666],
                                    ['y' => '2018 Q2', 'item1' => 2778, 'item2' => 2294],
                                    ['y' => '2018 Q3', 'item1' => 4912, 'item2' => 1969],
                                    ['y' => '2018 Q4', 'item1' => 3767, 'item2' => 3597],
                                    ['y' => '2019 Q1', 'item1' => 6810, 'item2' => 1914],
                                    ['y' => '2019 Q2', 'item1' => 5670, 'item2' => 4293],
                                    ['y' => '2019 Q3', 'item1' => 4820, 'item2' => 3795],
                                    ['y' => '2019 Q4', 'item1' => 15073, 'item2' => 5967],
                                    ['y' => '2020 Q1', 'item1' => 10687, 'item2' => 4460],
                                    ['y' => '2020 Q2', 'item1' => 8432, 'item2' => 5713],
                                ]
                            ]
                        ]) ?>
                    </div>
                    <div id="sales-chart" class="chart tab-pane">
                        <?= MorrisDonut::widget([
                            'status' => true,
                            'clientOptions' => [
                                'colors' => ['#3c8dbc', '#f56954', '#00a65a'],
                                'data' => [
                                    ['label' => 'Download Sales', 'value' => 12],
                                    ['label' => 'In-Store Sales', 'value' => 30],
                                    ['label' => 'Mail-Order Sales', 'value' => 20],
                                ],
                            ]
                        ]) ?>
                    </div>
                    <div id="line-chart" class="chart tab-pane">
                        <?= MorrisLine::widget([
                            'status' => true,
                            'clientOptions' => [
                                'xkey' => 'y',
                                'ykeys' => ['item1'],
                                'labels' => ['Item 1'],
                                'lineColors' => ['#3c8dbc'],
                                'data' => [
                                    ['y' => '2018 Q1', 'item1' => 2666],
                                    ['y' => '2018 Q2', 'item1' => 2778],
                                    ['y' => '2018 Q3', 'item1' => 4912],
                                    ['y' => '2018 Q4', 'item1' => 3767],
                                    ['y' => '2019 Q1', 'item1' => 6810],
                                    ['y' => '2019 Q2', 'item1' => 5670],
                                    ['y' => '2019 Q3', 'item1' => 4820],
                                    ['y' => '2019 Q4', 'item1' => 15073],
                                    ['y' => '2020 Q1', 'item1' => 10687],
                                    ['y' => '2020 Q2', 'item1' => 8432],
                                ]
                            ]
                        ]) ?>
                    </div>
                    <div id="bar-chart" class="chart tab-pane">
                        <?= MorrisBar::widget([
                            'status' => true,
                            'clientOptions' => [
                                'xkey' => 'y',
                                'ykeys' => ['a', 'b'],
                                'labels' => ['CPU', 'DISK'],
                                'barColors' => ['#00a65a', '#f56954'],
                                'data' => [
                                    ['y' => '2014', 'a' => 100, 'b' => 90],
                                    ['y' => '2015', 'a' => 75, 'b' => 65],
                                    ['y' => '2016', 'a' => 50, 'b' => 40],
                                    ['y' => '2017', 'a' => 75, 'b' => 65],
                                    ['y' => '2018', 'a' => 50, 'b' => 40],
                                    ['y' => '2019', 'a' => 75, 'b' => 65],
                                    ['y' => '2020', 'a' => 100, 'b' => 90],
                                ]
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
