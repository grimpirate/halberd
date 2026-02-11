<?php

namespace GrimPirate\Halberd;

class ComposerScripts
{
	public static function postUpdate(): void
	{
		$notSrc = array_filter(self::listAllFiles(__DIR__ . DIRECTORY_SEPARATOR . '../'), function($path) {
			if(1 === preg_match('/^.*\/grimpirate\/halberd\/composer.json$/', $path)) return false;
			if(1 === preg_match('/^.*\/grimpirate\/halberd\/src.*$/', $path)) return false;
			return true;
		});

		usort($notSrc, function($pathA, $pathB) {
			if(is_file($pathA) && is_dir($pathB)) return -1;
			if(is_dir($pathA) && is_file($pathB)) return 1;
			if(is_dir($pathA) && is_dir($pathB)) return strlen($pathA) < strlen($pathB) ? 1 : -1;
			return 0;
		});

		foreach($notSrc as $path)
			if(is_file($path))
				unlink($path);
			else
				rmdir($path);
	}

	public static function listAllFiles($dir): array
	{
		$array = array_diff(scandir($dir), array('.', '..'));

		foreach($array as &$item)
			$item = realpath($dir . $item);

		unset($item);

		foreach($array as $item)
			if(is_dir($item))
				$array = array_merge($array, self::listAllFiles($item . DIRECTORY_SEPARATOR));

		return $array;
	}
}
