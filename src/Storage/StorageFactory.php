<?php

namespace Up\Storage;

class StorageFactory
{
	public static function create(StorageType $type): StorageInterface
	{
		$className = $type->getClassName();

		if (!class_exists($className))
		{
			throw new \InvalidArgumentException("$className doesn't exist");
		}

		$reflectionClass = new \ReflectionClass($className);

		if (!$reflectionClass->implementsInterface(StorageInterface::class))
		{
			throw new \InvalidArgumentException("$className doesn't implement StorageInterface");
		}

		return $reflectionClass->newInstance();
	}
}
