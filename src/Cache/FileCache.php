<?php

namespace Up\Cache;

use Closure;
use Up\Service\ConfigurationService;

class FileCache extends Cache
{
	public static string $cacheDir;

	public function __construct()
	{
		self::$cacheDir = ConfigurationService::option('file_storage.FILE_PATH');
	}

	public function set(string $key, mixed $value, int $ttl): void
	{
		$hash = sha1($key);
		$path = self::$cacheDir . $hash . '.php';

		$data = [
			'data' => $value,
			'ttl' => time() + $ttl,
		];

		file_put_contents($path, serialize($data));
	}

	public function get(string $key): mixed
	{
		// TODO: set list of allowed classes
		$hash = sha1($key);
		$path = self::$cacheDir . $hash . '.php';

		if (!file_exists($path))
		{
			return null;
		}

		$data = unserialize(
			file_get_contents($path),
			['allowed_classes' => false]
		);
		$ttl = $data['ttl'];

		if (time() >= $ttl)
		{
			unlink($path);
			return null;
		}

		return $data['data'];
	}

	public function delete(string $key): void
	{
		$hash = sha1($key);
		if (file_exists(self::$cacheDir))
		{
			foreach (glob(self::$cacheDir . "$hash*") as $file)
			{
				unlink($file);
			}
		}
	}

	public function deleteAll(): void
	{
		if (file_exists(self::$cacheDir))
		{
			foreach (glob(self::$cacheDir . '*') as $file)
			{
				unlink($file);
			}
		}
	}
	public function cleanup(): void
	{
		// TODO: set list of allowed classes
		$currentTime = time();
		foreach (glob(self::$cacheDir . '*') as $file)
		{
			$data = unserialize(file_get_contents($file), ['allowed_classes' => false]);
			if ($currentTime > $data['ttl'])
			{
				unlink($file);
				echo "Cleanup: $file\n";
			}
		}
	}
}