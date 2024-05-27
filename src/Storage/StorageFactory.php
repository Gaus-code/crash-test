<?php

namespace Up\Storage;

class StorageFactory
{
	public static function create(StorageType $type): StorageInterface
	{
		return match ($type)
		{
			StorageType::MemoryStorage => new MemoryStorage(),
			StorageType::FileStorage => new FileStorage(),
			StorageType::RedisStorage => new RedisStorage(),
		};
	}
}
