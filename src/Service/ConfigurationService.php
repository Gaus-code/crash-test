<?php

declare(strict_types=1);

namespace Up\Service;

use RuntimeException;

class ConfigurationService
{
	private static ?array $config = null;

	private static function loadConfig(): void
	{
		if (self::$config === null)
		{
			$masterConfig = require ROOT . '/config/config.php';
			$localConfig = file_exists(ROOT . '/config/local-config.php') ? require ROOT . '/config/local-config.php' : [];
			self::$config = array_merge($masterConfig, $localConfig);
		}
	}

	public static function option(string $name, mixed $defaultValue = null): mixed
	{
		self::loadConfig();

		$parts = explode('.', $name);
		$current = self::$config;

		foreach ($parts as $part)
		{
			if (!isset($current[$part]))
			{
				if ($defaultValue !== null)
				{
					return $defaultValue;
				}
				throw new RuntimeException("Configuration option $name not found");
			}
			$current = $current[$part];
		}

		return $current;
	}
}
