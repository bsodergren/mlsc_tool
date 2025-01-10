<?php

/**
 * Command like Metatag writer for video files.
 */

namespace MLSC\Commands\Add;

use MLSC\Core\MLSCCommand;
use Symfony\Component\Console\Attribute\AsCommand;

const DESCRIPTION = 'Example Description';
const NAME        = 'add';
#[AsCommand(name: NAME, description: DESCRIPTION)]

final class Command extends MLSCCommand
{
    use Lang;
}
