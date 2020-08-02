<?php

use yii\widgets\DetailView;
use modules\rbac\Module;

/** @var $model yii\rbac\Role[]|yii\rbac\Permission[] */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'name',
            'label' => Module::t('module', 'Name'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'description',
            'label' => Module::t('module', 'Description'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'ruleName',
            'label' => Module::t('module', 'Rule Name'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'data',
            'label' => Module::t('module', 'Data'),
            'format' => 'raw'
        ],
        [
            'attribute' => 'createdAt',
            'label' => Module::t('module', 'Created'),
            'format' => 'datetime'
        ],
        [
            'attribute' => 'updatedAt',
            'label' => Module::t('module', 'Updated'),
            'format' => 'datetime'
        ]
    ]
]);
