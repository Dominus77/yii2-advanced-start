# ChartJs Widget

[www.chartjs.org](https://www.chartjs.org/docs/latest/)

## Usage
View:
```php
use backend\widgets\chart\chartjs\Chart;

// Area
echo Chart::widget([
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
]);

// Doughnut
echo Chart::widget([
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
]);

// Pie
echo Chart::widget([
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
]);

// Line
echo Chart::widget([
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
]);

// Bar
echo Chart::widget([
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
]);

// Radar
echo Chart::widget([
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
]);

// Bubble
echo Chart::widget([
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
]);
```
More information see [Documentation chartjs](https://www.chartjs.org/docs/latest/)