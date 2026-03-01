<?php

namespace GrimPirate\Halberd;

class ComposerScripts
{
	public static function postUpdate(): void
	{
		self::removeDirectory(__DIR__ . '/../.github');
		self::removeDirectory(__DIR__ . '/../docs');
		unlink(__DIR__ . '/../LICENSE');
		unlink(__DIR__ . '/../zensical.toml');
	}

	public static function removeDirectory($dir): void
	{
		$notSrc = self::listAllFiles($dir);

		usort($notSrc, function($pathA, $pathB) {
			if(is_file($pathA) && is_dir($pathB)) return -1;
			if(is_dir($pathA) && is_file($pathB)) return 1;
			return strcasecmp($pathB, $pathA);
		});

		foreach($notSrc as $path)
			if(is_file($path))
				unlink($path);
			else
				rmdir($path);

		rmdir($dir);
	}

	public static function listAllFiles($dir): array
	{
		$dir = rtrim(realpath($dir), "/\\") . DIRECTORY_SEPARATOR;

		$array = array_diff(scandir($dir), array('.', '..'));

		foreach($array as &$item)
			$item = $dir . $item;

		unset($item);

		foreach($array as $item)
			if(is_dir($item))
				$array = array_merge($array, self::listAllFiles($item . DIRECTORY_SEPARATOR));

		return $array;
	}
}
