<?php

/**
 * CWP Media tool
 */

namespace MLSC\Commands\Set;

use MLSC\Core\MLSCCommand;
use Symfony\Component\Console\Attribute\AsCommand;

const DESCRIPTION = 'Example Description';
const NAME        = 'set';
#[AsCommand(name: NAME, description: DESCRIPTION)]

final class Command extends MLSCCommand
{
    use Lang;
    public $CommandArguments = [
        ['type', 'REQUIRED', 'wireless event'],
        ['name', 'OPTIONAL', 'data string']
    ];
}
