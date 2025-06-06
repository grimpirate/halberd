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
		$this->description   = lang('TOTP.spark.initialize.description');
		$this->usage = lang('TOTP.spark.initialize.usage');

		$this->vendorPath = service('autoloader')->getNamespace('GrimPirate\Halberd')[0] . '../';
	}

	public function run(array $params)
	{
		$this->merge('app', 'Config');
		$this->merge('public', 'css');

		$publisher = new Publisher();

		$publisher->addLineAfter(
			APPPATH . 'Config/Auth.php',
			"        'action_totp_2fa'             => '\\GrimPirate\\Halberd\\Views\\totp_2fa_show',",
			'public array $views = [',
		);

		$publisher->replace(
			APPPATH . 'Config/Auth.php',
			[
				"'login'    => null," => "'login'    => \\GrimPirate\\Halberd\\Authentication\\Actions\\TOTPActivator::class,",
				"'register' => null," => "'register' => \\GrimPirate\\Halberd\\Authentication\\Actions\\TOTPActivator::class,",
			],
		);

		$publisher->addLineAfter(
			APPPATH . 'Config/Auth.php',
			"        'totp'    => \\GrimPirate\\Halberd\\Authentication\\Authenticators\\TOTP::class,",
			'public array $authenticators = [',
		);
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