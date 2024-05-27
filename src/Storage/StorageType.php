<?php

namespace Up\Storage;

enum StorageType
{
	case MemoryStorage;
	case FileStorage;
	case RedisStorage;

	public function getClassName(): string
	{
		return __NAMESPACE__ . '\\' . $this->name;
	}
}