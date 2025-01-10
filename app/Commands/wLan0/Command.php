<?php

/**
 * Command like Metatag writer for video files.
 */

namespace MLSC\Commands\wLan0;

use MLSC\Core\MLSCCommand;
use Symfony\Component\Console\Attribute\AsCommand;

const DESCRIPTION = 'Example Description';
const NAME        = 'wlan0';
#[AsCommand(name: NAME, description: DESCRIPTION)]

final class Command extends MLSCCommand
{
    use Lang;

    public $CommandArguments = [
        ['event', 'REQUIRED', 'wireless event'],
        ['macid', 'OPTIONAL', 'data string']
    ];
}
