<?php

namespace Up\Cache;

use Closure;
use Up\Service\ConfigurationService;

class RedisCache implements CacheInterface
{
	private string $host;
	private int $port;

	public function __construct(string $host = null, int $port = null)
	{
		$this->host = $host ?? ConfigurationService::option('redis.DB_HOST');
		$this->port = $port ?? (int) ConfigurationService::option('redis.DB_PORT');
	}

	public function set(string $key, mixed $value, int $ttl): void
	{
		// TODO: Implement set() method.
		echo "Set key: $key with TTL: $ttl\n";
	}

	public function get(string $key): mixed
	{
		// TODO: Implement get() method.
		return "Get key: $key\n";
	}

	public function remember(string $key, int $ttl, Closure $fetcher): mixed
	{
		// TODO: Implement remember() method.
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
		// TODO: Implement delete() method.
		echo "Delete key: $key\n";
	}

	public function deleteAll(): void
	{
		// TODO: Implement deleteAll() method.
		echo "Delete all keys\n";
	}
}