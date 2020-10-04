# Yii2 Passfield

Pass*Field is a javascript that simplifies creation of sophisticated password fields. Docs and live demo are
http://antelle.github.io/passfield/

```
\modules\users\components\widgets\passfield\Passfield::widget([
    'form' => $form,
    'model' => $model,
    'attribute' => 'password',
    'options' => [
        'class' => 'form-control',
    ],
    'config' => [
        'locale' => mb_substr(Yii::$app->language, 0, strrpos(Yii::$app->language, '_')),
        'showToggle' => true,
        'showGenerate' => true,
        'showWarn' => true,
        'showTip' => true,
        'length' => [
            'min' => 8,
            'max' => 16,
        ]
    ],
]);
```
