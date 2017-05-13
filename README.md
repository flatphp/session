# Sutile\Session
This is a light session component;

## Install
```php
composer require "flatphp/session"
```


## Useage


```PHP
// Based on cache

use Flatphp\Cache\Cache;
Cache::init(array(
    'store' => array(
        'driver' => 'redis',
        'host' => 'localhost',
        'port' => 6379
    )
));

Session::init(array(
    'lifetime' => 1440,
    'handler' => 'cache'
));

Session::set('test', 1);
echo Session::get('test');
Session::delete('test');
echo Session::getId();
```

