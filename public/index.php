<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../boot.php';

$fileStorage = new \Up\Cache\FileStorage();
$redisStorage = new \Up\Cache\RedisStorage();
$memoryStorage = new \Up\Cache\MemoryStorage();

//try FileCache
$fileCache = new Up\Cache\Cache($fileStorage);
$fileCache->set('eleven', 'hehehe', 5);

$fileCache->remember('remember', 120, function () {
	return 'new remember';
});

$fileCache->deleteAll();
$value = $fileCache->get('remember');

$value2 = $fileCache->get('eleven');
echo $value ?? 'null';
echo '<br>';
echo  $value2 ?? 'null';
