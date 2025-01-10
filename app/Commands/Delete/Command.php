<?php

/**
 * CWP Media tool
 */

namespace MLSC\Commands\Delete;

use MLSC\Core\MLSCCommand;
use Symfony\Component\Console\Attribute\AsCommand;

const DESCRIPTION = 'Example Description';
const NAME        = 'delete';
#[AsCommand(name: NAME, description: DESCRIPTION)]

final class Command extends MLSCCommand
{
    use Lang;
}
