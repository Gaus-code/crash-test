<?php

namespace Up\Cache;

use Closure;

class MemoryCache implements CacheInterface
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

		if (time() < $ttl)
		{
			return null;
		}

		return $data['data'];
	}

	public function remember(string $key, int $ttl, Closure $fetcher): mixed
	{
		$data = $this->get($key);

		if ($data === null)
		{
			$value = $fetcher();
			$this->set($key, $value, $ttl);

			return $value;
		}

		return $data;
	}

	public function delete(string $key): void
	{
		unset(self::$cache[$key]);
	}

	public function deleteAll(): void
	{
		self::$cache = [];
	}

	public function cleanup(): void
	{
		foreach (self::$cache as $key => $data)
		{
			if (time() < $data['ttl'])
			{
				$this->delete($key);
			}
		}
	}
}