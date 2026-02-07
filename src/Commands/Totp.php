<?php

namespace GrimPirate\Halberd\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\Commands;
use Psr\Log\LoggerInterface;

class Totp extends BaseCommand
{
    protected $group =          'Halberd';
    protected $name =           'halberd:totp';

    public function __construct(LoggerInterface $logger, Commands $commands)
    {
        parent::__construct($logger, $commands);
        $this->description   = lang('Totp.spark.totp.description');
        $this->usage = lang('Totp.spark.totp.usage');
        $this->arguments = [
            'id' => lang('Totp.spark.totp.arguments.id'),
        ];
    }

    public function run(array $params)
    {
        service('halberd')->regenerateIdentity(!isset($params[0]) ? CLI::prompt(lang('Totp.spark.totp.input.id'), null, 'required') : $params[0]);
    }
}