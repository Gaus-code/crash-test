<?php

namespace Up\Storage;

interface StorageInterface
{
	public function set(string $key, mixed $value, int $ttl): void;
	public function get(string $key): mixed;
	public function delete(string $key): void;
	public function deleteAll(): void;
}