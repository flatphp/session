<?php
require dirname(__DIR__) .'/vendor/autoload.php';

use Flatphp\Cache\Cache;
use Flatphp\Session\Session;

Cache::init(array(
    'store' => array(
        'driver' => 'memcache',
        'host' => '127.0.0.1',
        'port' => 11211
    )
));
Session::init(array(
    'lifetime' => 1440,
    //'handler' => 'cache'
));

Session::set('test', 'hello');
$val = Session::get('test');
$msgs = [];
if ($val != 'hello') {
    $msgs[] = 'Expecte hello but value is '. $val;
}
if (!Session::has('test')) {
    $msgs[] = 'Expecte has test key';
}
if (!Session::getId()) {
    $msgs[] = 'Expecte session id not empty';
}
Session::delete('test');
$val = Session::get('test');
if ($val !== null) {
    $msgs[] = 'Expecte null, value is '. $val;
}

if (!empty($msgs)) {
    foreach ($msgs as $k=>$error) {
        $k++;
        echo $k .'. '. $error .'<br>';
    }
} else {
    echo 'OK';
}