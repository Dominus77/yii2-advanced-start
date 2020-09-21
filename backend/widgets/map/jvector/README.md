# JVector Map Widget

[jvectormap.com](https://jvectormap.com/)

## Usage

```php
echo backend\widgets\map\jvector\Map::widget([
    'status' => true,
    'containerOptions' => [
        'style' => 'height: 250px; width:100%;'
    ],
    // Set maps
    /*'maps' => [
        'world_mill_en' => 'world-mill-en',
        'default' => 'world-mill-en',
    ],*/
    'clientOptions' => [
        //'map' => 'world_mill_en', // or default if set maps
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
            let regions = $(this).data().mapObject.params.series.regions,
                visitorsData = regions[0].values;
            if (typeof visitorsData[code] !== 'undefined') {
                el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
            }
        ")
    ]
]);
```
