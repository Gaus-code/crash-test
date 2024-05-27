<?php

namespace Up\Cache;

use Closure;
use Up\Storage\StorageFactory;
use Up\Storage\StorageInterface;
use Up\Storage\StorageType;

class Cache
{
	protected StorageInterface $storage;

	public function __construct(StorageType $storageType)
	{
		$this->storage = StorageFactory::create($storageType);
	}
	public function set(string $key, mixed $value, int $ttl): void
	{
		$this->storage->set($key, $value, $ttl);
	}
	public function get(string $key): mixed
	{
		return $this->storage->get($key);
	}
	public function remember(string $key, int $ttl, Closure $fetcher): mixed
	{
		$data = $this->storage->get($key);

		if ($data === null)
		{
			$value = $fetcher();
			$this->storage->set($key, $value, $ttl);

			return $value;
		}

		return $data;
	}
	public function delete(string $key): void
	{
		$this->storage->delete($key);
	}
	public function deleteAll(): void
	{
		$this->storage->deleteAll();
	}
}