<?php

namespace GrimPirate\Halberd\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\Commands;
use CodeIgniter\Publisher\Publisher;
use Psr\Log\LoggerInterface;

class Initialize extends BaseCommand
{
	protected $group =          'Halberd';
	protected $name =           'halberd:ini';

	protected $vendorPath = null;

	public function __construct(LoggerInterface $logger, Commands $commands)
	{
		parent::__construct($logger, $commands);
		$this->description   = lang('Totp.spark.initialize.description');
		$this->usage = lang('Totp.spark.initialize.usage');

		$this->vendorPath = service('autoloader')->getNamespace('GrimPirate\Halberd')[0] . '../';
	}

	public function run(array $params)
	{
		$this->merge('app', 'Config');

	}

	private function merge($path, $sub)
	{
		try
		{
			$publisher = new Publisher("{$this->vendorPath}{$path}/", ROOTPATH . "{$path}/");

			$publisher->addPaths([
				$sub
			])->merge(false);
		}
		catch(\Throwable $e)
		{
			$this->showError($e);

			die();
		}
	}
}