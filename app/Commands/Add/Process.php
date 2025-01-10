<?php

/**
 * CWP Media tool
 */

namespace MLSC\Commands\Add;

use MLSC\Core\MLSC;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Process extends MLSC
{
    public $defaultCommands = [
        'exec' => null,
    ];

    public $commandList     = [
    ];

    public function __construct(InputInterface $input = null, OutputInterface $output = null, $args = null)
    {
        parent::boot($input, $output);
    }

    public function __call($m, $a)
    {
        return null;
    }

    public function exec($option = null)
    {
    }

    public function print()
    {
        dd('Add');
    }
}
