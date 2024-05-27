<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../boot.php';

//try FileCache
$storageType = \Up\Storage\StorageType::FileStorage;

$cache = new Up\Cache\Cache($storageType);

$cache->set('super_key', 'super_value', 3600);
$cache->remember('super_remember', 3600, function () {
	return 'super_value_for_super_remember';
});

$cache->deleteAll();
$value = $cache->get('super_key');
$remember = $cache->get('super_remember');

echo $value ?? 'null';
echo '<br>';
echo $remember ?? 'null';
