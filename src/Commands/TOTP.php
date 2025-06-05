<?php

namespace GrimPirate\Halberd\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\Commands;
use Psr\Log\LoggerInterface;

class TOTP extends BaseCommand
{
    protected $group =          'Halberd';
    protected $name =           'halberd:totp';

    public function __construct(LoggerInterface $logger, Commands $commands)
    {
        parent::__construct($logger, $commands);
        $this->description   = lang('TOTP.spark.totp.description');
        $this->usage = lang('TOTP.spark.totp.usage');
        $this->arguments = [
            'id' => lang('TOTP.spark.totp.arguments.id'),
        ];
    }

    public function run(array $params)
    {
        service('halberd')->regenerateIdentity(!isset($params[0]) ? CLI::prompt(lang('TOTP.spark.totp.input.id'), null, 'required') : $params[0]);
    }
}