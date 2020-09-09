<?php

use yii\widgets\DetailView;
use modules\rbac\Module;

/** @var $model yii\rbac\Role[]|yii\rbac\Permission[] */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'name',
            'label' => Module::translate('module', 'Name'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'description',
            'label' => Module::translate('module', 'Description'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'ruleName',
            'label' => Module::translate('module', 'Rule Name'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'data',
            'label' => Module::translate('module', 'Data'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'createdAt',
            'label' => Module::translate('module', 'Created'),
            'format' => 'datetime'
        ],
        [
            'attribute' => 'updatedAt',
            'label' => Module::translate('module', 'Updated'),
            'format' => 'datetime'
        ]
    ]
]);
