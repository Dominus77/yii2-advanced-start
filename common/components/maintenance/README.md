# Yii2 Maintenance mode component

Add to your config file:
```php
'bootstrap' => [
    'common\components\maintenance\Maintenance'
],
...
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
                        'debug/default/toolbar',
                        'debug/default/view',
                        'site/login',
                    ]
                ]
            ],

            // HTTP Status Code
            'statusCode' => 503,

            //Retry-After header
            'retryAfter' => 120 // or Wed, 21 Oct 2015 07:28:00 GMT for example
        ],
        'common\components\maintenance\StateInterface' => [
            'class' => 'common\components\maintenance\states\FileState',

            // optional: use different filename for controlling maintenance state:
            // 'fileName' => 'myfile.ext',

            // optional: use different directory for controlling maintenance state:
            // 'directory' => '@mypath',
        ]
    ]
]
```

## Filters
You can use filters for allow excepts:

```php
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
                        'debug/default/toolbar',
                        'debug/default/view',
                        'site/login',
                    ]
                ],
                // Allowed roles filter
                [
                    'class' => 'common\components\maintenance\filters\RoleFilter',
                    'roles' => [
                        'administrator',
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
                        'BrusSENS',
                    ],
                ]
            ],
        ]
    ]
]
```
You can create custom filter:
```php
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
'container' => [
    'singletons' => [
        'common\components\maintenance\StateInterface' => [
            'class' => 'common\components\maintenance\states\FileState',
            // optional: use different filename for controlling maintenance state:
            // 'fileName' => 'myfile.ext',

            // optional: use different directory for controlling maintenance state:
            // 'directory' => '@mypath',
        ]
    ]
],
'controllerMap' => [
      'maintenance' => [
          'class' => 'common\components\maintenance\commands\MaintenanceController',
      ],
],

```

Now you can set mode by command:
```
php yii maintenance/enable
```
```
php yii maintenance/disable
```
