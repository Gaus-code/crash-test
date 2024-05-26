<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../boot.php';

//file
$cache = new \Up\Cache\FileCache();

$cache->set('eleven', 'hehehe', 5);
$cache->set('twelve', 'Sad_hehehe', 5);

$value1 = $cache->get('eleven');
$value2 = $cache->get('twelve');

//$cache->deleteAll();
$cache->delete('eleven');
$cache->delete('twelve');
echo $value1 ?? 'null';
echo '<br>';
echo $value2 ?? 'null';


//redis
$cache2 = new \Up\Cache\RedisCache();

$cache2->set('hello', 'world', 2024);
$redisValue = $cache2->get('hello');
echo '<br>';
echo $redisValue;

$cache2->delete($redisValue);
