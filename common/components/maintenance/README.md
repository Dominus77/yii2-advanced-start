# Yii2 Maintenance mode component

Switching the site into maintenance mode with a timer and user subscription form displayed.

## Use
Add to your config file:
```php
// frontend/config/main.php
$config = [
    'bootstrap' => [
        //...
        'common\components\maintenance\Maintenance'
    ],
    //...
    'container' => [
        'singletons' => [
            'common\components\maintenance\Maintenance' => [
                'class' => 'common\components\maintenance\Maintenance',
    
                // Route to action
                'route' => 'maintenance/index',
    
                // Filters. Read Filters for more info.
                'filters' => [
                    [
                        'class' => 'common\components\maintenance\filters\URIFilter',
                        'uri' => [
                            'debug/default/view',
                            'debug/default/toolbar',
                            'maintenance/subscribe',
                            'users/default/login',
                            'users/default/logout',
                            'users/default/request-password-reset'
                        ]
                    ]
                ],
    
                // HTTP Status Code
                'statusCode' => 503,
    
                //Retry-After header
                'retryAfter' => 120 // or Wed, 21 Oct 2015 07:28:00 GMT for example
            ],
            'common\components\maintenance\interfaces\StateInterface' => [
                'class' => 'common\components\maintenance\states\FileState',
                // optional: format datetime
                // 'dateFormat' => 'd-m-Y H:i:s',
    
                // optional: use different filename for controlling maintenance state:
                // 'fileName' => 'my_file.ext',
                // optional: use a different file name to store subscribers of end-of-service notify
                // 'fileSubscribe' => 'my_file_subscribe.ext',
    
                // optional: use different directory for controlling maintenance state:
                'directory' => '@runtime',
            ]
        ]
    ]
    //..
];
```

## Filters
You can use filters for allow excepts:

```php
// frontend/config/main.php
$config = [
    //...
    'container' => [
        'singletons' => [
            'common\components\maintenance\Maintenance' => [
                'class' => 'common\components\maintenance\Maintenance',
                // Route to action
                'route' => 'maintenance/index',
                // Filters. Read Filters for more info.
                'filters' => [
                    //Allowed URIs filter. Your can allow debug panel URI.
                    [
                        'class' => 'common\components\maintenance\filters\URIFilter',
                        'uri' => [
                            'debug/default/view',
                            'debug/default/toolbar',
                            'maintenance/subscribe',
                            'users/default/login',
                            'users/default/logout',
                            'users/default/request-password-reset'
                        ]
                    ],
                    // Allowed roles filter
                    [
                        'class' => 'common\components\maintenance\filters\RoleFilter',
                        'roles' => [
                            modules\rbac\models\Permission::PERMISSION_MAINTENANCE,
                        ]
                    ],
                    // Allowed IP addresses filter
                    [
                        'class' => 'common\components\maintenance\filters\IpFilter',
                        'ips' => [
                            '127.0.0.1',
                        ]
                    ],
                    //Allowed user names
                    [
                        'class' => 'common\components\maintenance\filters\UserFilter',
                        'checkedAttribute' => 'username',
                        'users' => [
                            'admin',
                        ],
                    ]
                ],
            ]
        ]
    ]
    //...
];
```
You can create custom filter:
```php
use common\components\maintenance\Filter;

class MyCustomFilter extends Filter
{
    public $time;

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return (bool) $this->time > 3600;
    }
}
```

## Set maintenance mode by console or dashboard

Add to your console or common config file:
```php
$config = [
    //...
    'container' => [
        'singletons' => [
            'common\components\maintenance\interfaces\StateInterface' => [
                'class' => 'common\components\maintenance\states\FileState',
                // optional: format datetime
                // 'dateFormat' => 'd-m-Y H:i:s',
                // optional: use different filename for controlling maintenance state:
                // 'fileName' => 'myfile.ext',
                // optional: use a different file name to store subscribers of end-of-service notify
                // 'fileSubscribe' => 'my_file_subscribe.ext',    
                // optional: use different directory for controlling maintenance state:
                'directory' => '@frontend/runtime',
            ]
        ]
    ],
    'controllerMap' => [
          //...
          'maintenance' => [
              'class' => 'common\components\maintenance\commands\MaintenanceController',
          ],
    ],
    //..
];
```

Now you can set mode by command:
```
php yii maintenance
php yii maintenance/enable --date="25-02-2025 16:05:00" --title="Maintenance" --content="The site is undergoing technical work. We apologize for any inconvenience caused." --subscribe=true
php yii maintenance/update --date="24-05-2023 19:05:00" --title="Maintenance" --content="The site is undergoing technical work. We apologize for any inconvenience caused." --subscribe=true
php yii maintenance/followers
php yii maintenance/disable
```
