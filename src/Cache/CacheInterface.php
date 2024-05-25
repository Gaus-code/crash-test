<?php

namespace Up\Cache;

use Closure;
interface CacheInterface
{
	public function set(string $key, mixed $value, int $ttl): void;
	public function get(string $key): mixed;
	public function remember(string $key, int $ttl, Closure $fetcher): mixed;
	public function delete(string $key): void;
	public function deleteAll(): void;
}