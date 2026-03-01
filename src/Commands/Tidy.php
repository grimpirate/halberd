<?php

namespace GrimPirate\Halberd\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\Commands;
use Psr\Log\LoggerInterface;

use GrimPirate\Halberd\ComposerScripts;

class Tidy extends BaseCommand
{
    protected $group =          'Halberd';
    protected $name =           'halberd:tidy';

    public function __construct(LoggerInterface $logger, Commands $commands)
    {
        parent::__construct($logger, $commands);
        $this->description   = lang('Totp.spark.tidy.description');
        $this->usage = lang('Totp.spark.tidy.usage');
    }

    public function run(array $params)
    {
        ComposerScripts::postUpdate();
    }
}