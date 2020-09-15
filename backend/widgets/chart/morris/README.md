# Morris Widgets

### Usage
View:
```php
<?php 

use backend\widgets\chart\morris\Area;
use backend\widgets\chart\morris\Donut;
use backend\widgets\chart\morris\Line;
use backend\widgets\chart\morris\Bar;

// Chart
echo Area::widget([
    'status' => true,
    'containerOptions' => [
        'style' => 'position:relative; height:300px; width:auto;'
    ],
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
]);

// Donut
echo Donut::widget([
    'status' => true,
    'containerOptions' => [
        'style' => 'position:relative; height:300px; width:auto;'
    ],
    'clientOptions' => [
        'colors' => ['#3c8dbc', '#f56954', '#00a65a'],
        'data' => [
            ['label' => 'Download Sales', 'value' => 12],
            ['label' => 'In-Store Sales', 'value' => 30],
            ['label' => 'Mail-Order Sales', 'value' => 20],
        ],
    ]
]);

// Donut
echo Line::widget([
    'status' => true,
    'containerOptions' => [
        'style' => 'position:relative; height:300px; width:auto;'
    ],
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
]);

// Bar
echo Bar::widget([
    'status' => true,
    'containerOptions' => [
        'style' => 'position:relative; height:300px; width:auto;'
    ],
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
]);
```
