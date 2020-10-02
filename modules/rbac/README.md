# Yii2 модуль управления доступом на основе ролей (RBAC)

Модуль содержит вэб-интерфейс для управления ролями, разрешениями и назначением прав пользователям.

## Подключение

common/config/main.php
```
return [
    // ...        
    'components' => [        
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        // ...
    ],
]
```

backend/config/main.php
```
return [
    // ...
    'bootstrap' => [        
        'modules\rbac\Bootstrap',    
    ],
    'modules' => [        
        'rbac' => [
            'class' => 'modules\rbac\Module',
            'params' => [
                'userClass' => 'modules\users\models\User',
            ]
        ],
        // ...
    ],
]
```

console/config/main.php
```
'bootstrap' => [
    // ...
    'modules\rbac\Bootstrap',    
],
...
'modules' => [
    'rbac' => [
        'class' => 'modules\rbac\Module',
        'params' => [
            'userClass' => 'modules\users\models\User',
        ]
    ],
],
```

Применить миграцию:
```
php yii migrate --migrationPath=@yii/rbac/migrations
```

Для инициализации и установки данных по умолчанию, выполнить команду:
```
php yii rbac/init
```

## Ссылки
Панель управления RBAC
```
/rbac/default/index
```

Управление разрешениями
```
/rbac/permissions/index
```

Управление ролями
```
/rbac/roles/index
```

Назначение прав пользователям
```
/rbac/assign/index
```

Установка настроек RBAC по умолчанию
```
/rbac/default/reset
```

## Документация
[Role Based Access Control (RBAC)](http://www.yiiframework.com/doc-2.0/guide-security-authorization.html#rbac)

## Лицензия
The BSD License (BSD). Please see [License File](https://github.com/Dominus77/yii2-advanced-start/blob/master/modules/rbac/LICENSE.md) for more information.

