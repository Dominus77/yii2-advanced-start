<?php

use modules\main\Module;
use backend\widgets\box\SmallBox;
use backend\widgets\chart\chartjs\Chart;
use backend\widgets\chart\flot\Chart as FlotChart;
use backend\widgets\map\jvector\Map;
use backend\widgets\chart\sparkline\Chart as SparklineChart;
use yii\helpers\Url;

/* @var $this yii\web\View */
/** @var $usersCount int */

$this->title = Module::translate('module', 'Home');
$this->params['title']['small'] = Module::translate('module', 'Dashboard');
?>

<section class="content main-backend-default-index">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_AQUA,
                'icon' => 'ion-bag',
                'header' => 150,
                'content' => 'New Orders',
                'link' => [
                    'label' => Yii::t(
                        'app',
                        'More info'
                    ) . ' <i class="fa fa-arrow-circle-right"></i>',
                    'url' => ['#']
                ]
            ]) ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_GREEN,
                'icon' => 'ion-stats-bars',
                'header' => '53<sup style="font-size: 20px">%</sup>',
                'content' => 'Bounce Rate',
                'link' => [
                    'label' => Yii::t(
                        'app',
                        'More info'
                    ) . ' <i class="fa fa-arrow-circle-right"></i>',
                    'url' => ['#']
                ]
            ]) ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_YELLOW,
                'icon' => 'ion-person-add',
                'header' => $usersCount,
                'content' => Yii::t('app', 'User Registrations'),
                'link' => [
                    'label' => Yii::t(
                        'app',
                        'More info'
                    ) . ' <i class="fa fa-arrow-circle-right"></i>',
                    'url' => ['/users/default/index']
                ]
            ]) ?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?= SmallBox::widget([
                'status' => true,
                'style' => SmallBox::BG_RED,
                'icon' => 'ion-pie-graph',
                'header' => 65,
                'content' => 'Unique Visitors',
                'link' => [
                    'label' => Yii::t(
                        'app',
                        'More info'
                    ) . ' <i class="fa fa-arrow-circle-right"></i>',
                    'url' => ['#']
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <section class="col-lg-7 connectedSortable">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#area-chart" data-toggle="tab">Area</a></li>
                    <li><a href="#doughnut-chart" data-toggle="tab">Doughnut</a></li>
                    <li><a href="#pie-chart" data-toggle="tab">Pie</a></li>
                    <li><a href="#line-chart" data-toggle="tab">Line</a></li>
                    <li><a href="#bar-chart" data-toggle="tab">Bar</a></li>
                    <li><a href="#radar-chart" data-toggle="tab">Radar</a></li>
                    <li><a href="#bubble-chart" data-toggle="tab">Bubble</a></li>
                    <li class="pull-left header"><i class="fa fa-bar-chart"></i> Charts</li>
                </ul>

                <div class="tab-content no-padding">
                    <div id="area-chart" class="chart tab-pane active">
                        <?= Chart::widget([
                            'status' => true,
                            'type' => Chart::TYPE_LINE,
                            'clientOptions' => [
                                'responsive' => true,
                                'title' => [
                                    'display' => true,
                                    'text' => 'Chart.js Area Chart'
                                ],
                                'scales' => [
                                    'xAxes' => [
                                        [
                                            'display' => true,
                                            'scaleLabel' => [
                                                'display' => true,
                                                'labelString' => 'Month'
                                            ]
                                        ]
                                    ],
                                    'yAxes' => [
                                        [
                                            'display' => true,
                                            'scaleLabel' => [
                                                'display' => true,
                                                'labelString' => 'Value'
                                            ]
                                        ]
                                    ],
                                ],
                            ],
                            'clientData' => [
                                'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                'datasets' => [
                                    [
                                        'label' => 'Electronics',
                                        'hidden' => false,
                                        'backgroundColor' => 'rgb(160, 208, 224, 0.5)',
                                        'borderColor' => 'rgb(160, 208, 224, 0.7)',
                                        'data' => [65, 59, 80, 81, 56, 55, 40]
                                    ],
                                    [
                                        'label' => 'Digital Goods',
                                        'hidden' => false,
                                        'backgroundColor' => 'rgb(60, 141, 188, 0.5)',
                                        'borderColor' => 'rgb(60, 141, 188, 0.7)',
                                        'data' => [28, 48, 40, 19, 86, 27, 90]
                                    ]
                                ],
                            ]
                        ]) ?>
                    </div>
                    <div id="doughnut-chart" class="chart tab-pane">
                        <?= Chart::widget([
                            'status' => true,
                            'type' => Chart::TYPE_DOUGHNUT,
                            'clientOptions' => [
                                'responsive' => true,
                                'legend' => [
                                    'position' => 'top'
                                ],
                                'title' => [
                                    'display' => true,
                                    'text' => 'Chart.js Doughnut Chart',
                                ],
                                'animation' => [
                                    'animateScale' => true,
                                    'animateRotate' => true,
                                ],
                            ],
                            'clientData' => [
                                'labels' => ['Download Sales', 'In-Store Sales', 'Mail-Order Sales'],
                                'datasets' => [
                                    [
                                        'label' => 'Electronics',
                                        'backgroundColor' => [
                                            '#3c8dbc',
                                            '#f56954',
                                            '#00a65a',
                                        ],
                                        'data' => [12, 30, 20]
                                    ],
                                    [
                                        'label' => 'Digital Goods',
                                        'backgroundColor' => [
                                            '#3c8dbc',
                                            '#f56954',
                                            '#00a65a',
                                        ],
                                        'data' => [20, 18, 50]
                                    ],
                                ],
                            ]
                        ]) ?>
                    </div>
                    <div id="pie-chart" class="chart tab-pane">
                        <?= Chart::widget([
                            'status' => true,
                            'type' => Chart::TYPE_PIE,
                            'clientOptions' => [
                                'responsive' => true,
                                'legend' => [
                                    'position' => 'top'
                                ],
                                'title' => [
                                    'display' => true,
                                    'text' => 'Chart.js Doughnut Chart',
                                ],
                                'animation' => [
                                    'animateScale' => true,
                                    'animateRotate' => true,
                                ],
                            ],
                            'clientData' => [
                                'labels' => ['Download Sales', 'In-Store Sales', 'Mail-Order Sales'],
                                'datasets' => [
                                    [
                                        'label' => 'Electronics',
                                        'backgroundColor' => [
                                            '#3c8dbc',
                                            '#f56954',
                                            '#00a65a',
                                        ],
                                        'data' => [12, 30, 20]
                                    ],
                                    [
                                        'label' => 'Digital Goods',
                                        'backgroundColor' => [
                                            '#3c8dbc',
                                            '#f56954',
                                            '#00a65a',
                                        ],
                                        'data' => [20, 18, 50]
                                    ],
                                ],
                            ]
                        ]) ?>
                    </div>
                    <div id="line-chart" class="chart tab-pane">
                        <?= Chart::widget([
                            'status' => true,
                            'type' => Chart::TYPE_LINE,
                            'clientOptions' => [
                                'responsive' => true,
                                'title' => [
                                    'display' => true,
                                    'text' => 'Chart.js Line Chart'
                                ],
                                'scales' => [
                                    'xAxes' => [
                                        [
                                            'display' => true,
                                            'scaleLabel' => [
                                                'display' => true,
                                                'labelString' => 'Month'
                                            ]
                                        ]
                                    ],
                                    'yAxes' => [
                                        [
                                            'display' => true,
                                            'scaleLabel' => [
                                                'display' => true,
                                                'labelString' => 'Value'
                                            ]
                                        ]
                                    ],
                                ],
                            ],
                            'clientData' => [
                                'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                'datasets' => [
                                    [
                                        'label' => 'Electronics',
                                        'hidden' => false,
                                        'fill' => false,
                                        'backgroundColor' => 'rgb(160, 208, 224, 0.5)',
                                        'borderColor' => 'rgb(160, 208, 224, 0.8)',
                                        'data' => [65, 59, 80, 81, 56, 55, 40]],
                                    [
                                        'label' => 'Digital Goods',
                                        'hidden' => false,
                                        'fill' => false,
                                        'backgroundColor' => 'rgb(60, 141, 188, 0.9)',
                                        'borderColor' => 'rgb(60, 141, 188, 0.8)',
                                        'data' => [28, 48, 40, 19, 86, 27, 90]
                                    ]
                                ],
                            ]
                        ]) ?>
                    </div>
                    <div id="bar-chart" class="chart tab-pane">
                        <?= Chart::widget([
                            'status' => true,
                            'type' => Chart::TYPE_BAR,
                            'clientOptions' => [
                                'responsive' => true,
                                'title' => [
                                    'display' => true,
                                    'text' => 'Chart.js Bar Chart'
                                ],
                                'scales' => [
                                    'xAxes' => [
                                        [
                                            'display' => true,
                                            'scaleLabel' => [
                                                'display' => true,
                                                'labelString' => 'Month'
                                            ]
                                        ]
                                    ],
                                    'yAxes' => [
                                        [
                                            'display' => true,
                                            'scaleLabel' => [
                                                'display' => true,
                                                'labelString' => 'Value'
                                            ]
                                        ]
                                    ],
                                ],
                            ],
                            'clientData' => [
                                'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                'datasets' => [
                                    [
                                        'label' => 'Electronics',
                                        'backgroundColor' => 'rgb(160, 208, 224, 0.5)',
                                        'data' => [65, 59, 80, 81, 56, 55, 40]],
                                    [
                                        'label' => 'Digital Goods',
                                        'backgroundColor' => 'rgb(60, 141, 188, 0.9)',
                                        'data' => [28, 48, 40, 19, 86, 27, 90]
                                    ]
                                ],
                            ]
                        ]) ?>
                    </div>
                    <div id="radar-chart" class="chart tab-pane">
                        <?= Chart::widget([
                            'status' => true,
                            'type' => Chart::TYPE_RADAR,
                            'clientOptions' => [
                                'responsive' => true,
                                'title' => [
                                    'display' => true,
                                    'text' => 'Chart.js Radar Chart'
                                ]
                            ],
                            'clientData' => [
                                'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                'datasets' => [
                                    [
                                        'label' => 'Electronics',
                                        'backgroundColor' => 'rgb(160, 208, 224, 0.5)',
                                        'data' => [65, 59, 80, 81, 56, 55, 40]],
                                    [
                                        'label' => 'Digital Goods',
                                        'backgroundColor' => 'rgb(60, 141, 188, 0.9)',
                                        'data' => [28, 48, 40, 19, 86, 27, 90]
                                    ]
                                ],
                            ]
                        ]) ?>
                    </div>
                    <div id="bubble-chart" class="chart tab-pane">
                        <?= Chart::widget([
                            'status' => true,
                            'type' => Chart::TYPE_BUBBLE,
                            'clientOptions' => [
                                'responsive' => true,
                                'title' => [
                                    'display' => true,
                                    'text' => 'Chart.js Bubble Chart',
                                ],
                                'tooltips' => [
                                    'mode' => 'point',
                                ],
                            ],
                            'clientData' => [
                                'animation' => [
                                    'duration' => 10000
                                ],
                                'datasets' => [
                                    [
                                        'label' => 'Electronics',
                                        'backgroundColor' => 'rgb(255, 0, 0, 0.5)',
                                        'borderColor' => 'rgb(255, 0, 0, 0.9)',
                                        'borderWidth' => 1,
                                        'data' => [
                                            ['x' => 30, 'y' => 40, 'r' => 20],
                                            ['x' => 18, 'y' => 12, 'r' => 10],
                                            ['x' => 60, 'y' => -35, 'r' => 5],
                                            ['x' => 48, 'y' => 40, 'r' => 10]
                                        ]
                                    ],
                                    [
                                        'label' => 'Digital Goods',
                                        'backgroundColor' => 'rgb(0, 255, 0, 0.5)',
                                        'borderColor' => 'rgb(0, 255, 0, 0.9)',
                                        'borderWidth' => 1,
                                        'data' => [
                                            ['x' => 10, 'y' => 25, 'r' => 17],
                                            ['x' => 25, 'y' => -10, 'r' => 25],
                                            ['x' => 40, 'y' => 55, 'r' => 30],
                                            ['x' => 35, 'y' => 20, 'r' => 16],
                                        ]
                                    ],
                                ],
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="col-lg-5 connectedSortable">
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-bar-chart-o"></i>
                    <h3 class="box-title">Flot Line Ajax Chart</h3>
                    <div class="box-tools pull-right">
                        Real time
                        <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                            <button type="button" class="btn btn-default btn-xs" data-toggle="on">On</button>
                            <button type="button" class="btn btn-danger btn-xs" data-toggle="off">Off</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <?= FlotChart::widget([
                        'status' => true,
                        'containerOptions' => [
                            'style' => 'height:300px;'
                        ],
                        'realtime' => [
                            'on' => true,
                            'dataUrl' => Url::to(['/main/default/get-demo-data']),
                            'btnGroupId' => 'realtime',
                            'btnDefault' => FlotChart::REALTIME_OFF,
                            'updateInterval' => 1000
                        ],
                        'clientData' => [
                            backend\components\Demo::getRandomData()
                        ],
                        'clientOptions' => [
                            'grid' => [
                                'borderColor' => '#f3f3f3',
                                'borderWidth' => 1,
                                'tickColor' => '#f3f3f3'
                            ],
                            'series' => [
                                'shadowSize' => 0, // Drawing is faster without shadows
                                'color' => '#3c8dbc',
                            ],
                            'lines' => [
                                'fill' => false, //Converts the line chart to area chart
                                'color' => '#3c8dbc',
                            ],
                            'yaxis' => [
                                'min' => 0,
                                'max' => 100,
                                'show' => true,
                            ],
                            'xaxis' => [
                                'show' => true,
                            ]
                        ],
                    ]) ?>
                </div>
            </div>
        </section>

        <section class="col-lg-5 connectedSortable">
            <div class="box box-solid bg-light-blue-gradient">
                <div class="box-header">
                    <div class="box-tools pull-right">
                        <!--<button type="button"
                         class="btn btn-primary btn-sm daterange pull-right"
                         data-toggle="tooltip"
                                title="Date range">
                            <i class="fa fa-calendar"></i></button>-->
                        <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                                data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <i class="fa fa-map-marker"></i>
                    <h3 class="box-title">Visitors</h3>
                </div>
                <div class="box-body">
                    <?= Map::widget([
                        'status' => true,
                        'containerOptions' => [
                            'style' => 'height: 250px; width:100%;'
                        ],
                        'maps' => [
                            'world_mill_en' => 'world-mill-en',
                            'world_mill' => 'world-mill'
                        ],
                        'clientOptions' => [
                            'map' => 'world_mill_en',
                            'backgroundColor' => 'transparent',
                            'regionStyle' => [
                                'initial' => [
                                    'fill' => '#e4e4e4',
                                    'fill-opacity' => 1,
                                    'stroke' => 'none',
                                    'stroke-width' => 0,
                                    'stroke-opacity' => 1
                                ]
                            ],
                            'series' => [
                                'regions' => [
                                    [
                                        'values' => backend\components\Demo::getVisitorsData(),
                                        'scale' => ['#92c1dc', '#ebf4f9'],
                                        'normalizeFunction' => 'polynomial',
                                    ]
                                ]
                            ],
                            'onRegionTipShow' => new yii\web\JsExpression("
                                function (e, el, code) {
                                    let regions = $(this).data().mapObject.params.series.regions,
                                        visitorsData = regions[0].values;
                                    if (typeof visitorsData[code] !== 'undefined') {
                                        el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
                                    }
                                }
                            ")
                        ]
                    ]) ?>
                </div>
                <div class="box-footer no-border">
                    <div class="row">
                        <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                            <?= SparklineChart::widget([
                                'status' => true,
                                'clientData' => [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
                                'clientOptions' => [
                                    'type' => 'line',
                                    'lineColor' => '#92c1dc',
                                    'fillColor' => '#ebf4f9',
                                    'height' => '50',
                                    'width' => '80'
                                ],
                            ]) ?>
                            <div class="knob-label">Visitors</div>
                        </div>
                        <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                            <?= SparklineChart::widget([
                                'status' => true,
                                'clientData' => [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
                                'clientOptions' => [
                                    'type' => 'line',
                                    'lineColor' => '#92c1dc',
                                    'fillColor' => '#ebf4f9',
                                    'height' => '50',
                                    'width' => '80'
                                ],
                            ]) ?>
                            <div class="knob-label">Online</div>
                        </div>
                        <div class="col-xs-4 text-center">
                            <?= SparklineChart::widget([
                                'status' => true,
                                'clientData' => [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
                                'clientOptions' => [
                                    'type' => 'line',
                                    'lineColor' => '#92c1dc',
                                    'fillColor' => '#ebf4f9',
                                    'height' => '50',
                                    'width' => '80'
                                ],
                            ]) ?>
                            <div class="knob-label">Exists</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
