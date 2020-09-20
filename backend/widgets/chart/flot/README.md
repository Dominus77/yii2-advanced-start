# Flot Charts Widget

[flotcharts.org](https://www.flotcharts.org/)

## Usage

### Flot Basic Options
```php
echo \backend\widgets\chart\flot\Chart::widget([
    'status' => true,
    'containerOptions' => [
        'style' => 'height:300px;'
    ],
    'clientData' => [
        [
            'label' => 'sin(x)',
            'data' => \backend\components\Demo::getSin()
        ],
        [
            'label' => 'cos(x)',
            'data' => \backend\components\Demo::getCos()
        ],
        [
            'label' => 'tan(x)',
            'data' => \backend\components\Demo::getTan()
        ],
    ],
    'clientOptions' => [
        'series' => [
            'lines' => [
                'show' => true
            ],
            'points' => [
                'show' => true
            ],
        ],
        'xaxis' => [
            'ticks' => [
                0,
                [M_PI / 2, '&pi;/2'],
                [M_PI, '&pi;'],
                [M_PI * 3 / 2, '3&pi;/2'],
                [M_PI * 2, '2&pi;']
            ],
        ],
        'yaxis' => [
            'ticks' => 10,
            'min' => -2,
            'max' => 2,
            'tickDecimals' => 3
        ],
        'grid' => [
            'backgroundColor' => [
                'colors' => ['#fff', '#eee'],
            ],
            'borderWidth' => [
                'top' => 1,
                'right' => 1,
                'bottom' => 2,
                'left' => 2
            ]
        ],
    ],
]);
```

### Flot Categories
```php
echo \backend\widgets\chart\flot\Chart::widget([
    'status' => true,
    'containerOptions' => [
        'style' => 'height:300px;'
    ],
    'clientData' => [
        [["January", 10], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9]]
    ],
    'clientOptions' => [
        'series' => [
            'bars' => [
                'show' => true,
                'barWidth' => 0.6,
                'align' => 'center'
            ],
            'color' => '#3c8dbc',
        ],
        'xaxis' => [
            'mode' => 'categories',
            'tickLength' => 0
        ]
    ],
]);
```

### Flot Line Realtime Ajax Chart

Controller: `modules\main\controllers\backend\DefaultController.php`
```php
/**
 * Get Demo Data
 *
 * @return array
 * @throws \yii\web\NotFoundHttpException
 */
public function actionGetDemoData()
{
    if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $post = Yii::$app->request->post();
        $data = (!empty($post['data'])) ? $post['data'] : [];
        return [
            'result' => \backend\components\Demo::getRandomData($data),
        ];
    }
    throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
}
```
View:

Buttons control on/off
```html
<div class="btn-group" id="realtime" data-toggle="btn-toggle">
    <button type="button" class="btn btn-default btn-xs" data-toggle="on">On</button>
    <button type="button" class="btn btn-danger btn-xs" data-toggle="off">Off</button>
</div>
```
Render Chart
```php
echo \backend\widgets\chart\flot\Chart::widget([
    'status' => true,
    'containerOptions' => [
        'style' => 'height:300px;'
    ],
    'realtime' => [
        'on' => true,        
        'dataUrl' => \yii\helpers\Url::to(['/main/default/get-demo-data']),
        'btnGroupId' => 'realtime',
        'btnDefault' => \backend\widgets\chart\flot\Chart::REALTIME_OFF,
        'updateInterval' => 1000
    ],
    'clientData' => [
        // Demo random data
        \backend\components\Demo::getRandomData()
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
]);
```
More examples in the package `\vendor\almasaeed2010\adminlte\bower_components\Flot\examples`