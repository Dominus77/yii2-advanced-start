# JVector Map Widget

[jvectormap.com](https://jvectormap.com/)

## Usage

```php
$clientData = \yii\helpers\Json::encode(\backend\components\Demo::getVisitorsData());
echo backend\widgets\map\jvector\Map::widget([
    'status' => true,
    'containerOptions' => [
        'style' => 'height: 250px; width:100%;'
    ],
    'clientOptions' => [
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
                    'values' => \yii\helpers\Json::decode($clientData),
                    'scale' => ['#92c1dc', '#ebf4f9'],
                    'normalizeFunction' => 'polynomial',
                ]
            ]
        ],
        'onRegionTipShow' => new \yii\web\JsExpression("                
            function (e, el, code) {
                let visitorsData = {$clientData};
                if (typeof visitorsData[code] !== 'undefined') {
                    el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
                }
            }
        ")
    ]
]);
```
