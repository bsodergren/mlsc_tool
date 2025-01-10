<?php

/**
 * CWP Media tool
 */

namespace MLSC\Commands\Reset;

use MLSC\Core\MLSCCommand;
use Symfony\Component\Console\Attribute\AsCommand;

const DESCRIPTION = 'Example Description';
const NAME        = 'reset';
#[AsCommand(name: NAME, description: DESCRIPTION)]

final class Command extends MLSCCommand
{
    use Lang;
}
