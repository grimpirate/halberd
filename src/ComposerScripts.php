<?php

namespace GrimPirate\Halberd;

class ComposerScripts
{
	public function postUpdate(array $params)
	{
		echo __DIR__;
	}

	private function removeDir(string $dir): void
	{
		// Create RecursiveDirectoryIterator with SKIP_DOTS flag to ignore '.' and '..'
		$it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
		// Create RecursiveIteratorIterator with CHILD_FIRST flag to ensure child items are processed first
		$files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

		foreach($files as $file)
		{
			if ($file->isDir())
			{
				// Remove directory
				rmdir($file->getPathname());
			}
			else
			{
				// Delete file
				unlink($file->getPathname());
			}
		}
		// Remove the main directory after its contents are empty
		rmdir($dir);
	}
}
