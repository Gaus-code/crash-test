<?php

namespace Up\Storage;

class MemoryStorage implements StorageInterface
{
	private static array $cache = [];

	public function set(string $key, mixed $value, int $ttl): void
	{
		self::$cache[$key] = [
			'data' => $value,
			'ttl' => time() + $ttl,
		];
	}

	public function get(string $key): mixed
	{
		if (!isset(self::$cache[$key]))
		{
			return null;
		}

		$data = self::$cache[$key];
		$ttl = $data['ttl'];

		if (time() <= $ttl)
		{
			unset(self::$cache[$key]);
			return null;
		}

		return $data['data'];
	}

	public function delete(string $key): void
	{
		unset(self::$cache[$key]);
	}

	public function deleteAll(): void
	{
		self::$cache = [];
	}
}