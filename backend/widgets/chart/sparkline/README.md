# Sparkline Chart Widget

[jquery-sparkline](https://omnipotent.net/jquery.sparkline/#s-about)

## Usage

```php
echo \backend\widgets\chart\sparkline\Chart::widget([
    'status' => true,
    'clientData' => [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
    'clientOptions' => [
        'type' => 'line',
        'lineColor' => '#92c1dc',
        'fillColor' => '#ebf4f9',
        'height' => '50',
        'width' => '80'
    ],
]);
```
