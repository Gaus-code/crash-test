<?php

namespace Up\Service;

class CleanupService
{
	private static string $cacheDir;

	public function __construct(string $cacheDir)
	{
		self::$cacheDir = ConfigurationService::option('file_storage.FILE_PATH');
	}
	public function cleanup(): void
	{
		$currentTime = time();
		foreach (glob(self::$cacheDir . '*') as $file)
		{
			$data = unserialize(file_get_contents($file),
				['allowed_classes' => false]
			);

			if ($currentTime > $data['ttl'])
			{
				unlink($file);
			}
		}
	}
}