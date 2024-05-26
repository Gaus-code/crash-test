<?php

namespace Up\Cache;

use Closure;
abstract class Cache
{
	abstract public function set(string $key, mixed $value, int $ttl): void;
	abstract public function get(string $key): mixed;
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
	abstract public function delete(string $key): void;
	abstract public function deleteAll(): void;
}