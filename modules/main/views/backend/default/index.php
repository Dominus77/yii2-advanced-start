<?php

use modules\main\Module;
use backend\widgets\box\SmallBox;
use backend\widgets\chart\chartjs\Area as ChartArea;

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
                        <?= ChartArea::widget([
                            'status' => true,
                            'containerOptions' => [
                                'style' => 'height:300px;',
                            ],
                            'clientOptions' => [
                                'showScale' => true,
                                'scaleShowGridLines' => false,
                                'scaleGridLineColor' => 'rgba(0,0,0,.05)',
                                'scaleGridLineWidth' => 1,
                                'scaleShowHorizontalLines' => true,
                                'scaleShowVerticalLines' => true,
                                'bezierCurve' => true,
                                'bezierCurveTension' => 0.3,
                                'pointDot' => false,
                                'pointDotRadius' => 4,
                                'pointDotStrokeWidth' => 1,
                                'pointHitDetectionRadius' => 20,
                                'datasetStroke' => true,
                                'datasetStrokeWidth' => 2,
                                'datasetFill' => true,
                                'legendTemplate' => '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>', // phpcs:ignore
                                'maintainAspectRatio' => true,
                                'responsive' => true,
                            ],
                            'clientData' => [
                                'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                'datasets' => [
                                    [
                                        'label' => 'Electronics',
                                        'fillColor' => 'rgba(210, 214, 222, 1)',
                                        'strokeColor' => 'rgba(210, 214, 222, 1)',
                                        'pointColor' => 'rgba(210, 214, 222, 1)',
                                        'pointStrokeColor' => '#c1c7d1',
                                        'pointHighlightFill' => '#fff',
                                        'pointHighlightStroke' => 'rgba(220,220,220,1)',
                                        'data' => [65, 59, 80, 81, 56, 55, 40]
                                    ],
                                    [
                                        'label' => 'Digital Goods',
                                        'fillColor' => 'rgba(60,141,188,0.9)',
                                        'strokeColor' => 'rgba(60,141,188,0.8)',
                                        'pointColor' => '#3b8bba',
                                        'pointStrokeColor' => 'rgba(60,141,188,1)',
                                        'pointHighlightFill' => '#fff',
                                        'pointHighlightStroke' => 'rgba(60,141,188,1)',
                                        'data' => [28, 48, 40, 19, 86, 27, 90]
                                    ]
                                ],
                            ]
                        ]) ?>
                    </div>
                    <div id="sales-chart" class="chart tab-pane">

                    </div>
                    <div id="line-chart" class="chart tab-pane">

                    </div>
                    <div id="bar-chart" class="chart tab-pane">

                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
