<?php

namespace Up\Storage;

enum StorageType
{
	case MemoryStorage;
	case FileStorage;
	case RedisStorage;
}