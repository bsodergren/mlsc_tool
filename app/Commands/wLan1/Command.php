<?php

/**
 * Command like Metatag writer for video files.
 */

namespace MLSC\Commands\wLan1;

use MLSC\Core\MLSCCommand;
use Symfony\Component\Console\Attribute\AsCommand;

const DESCRIPTION = 'Example Description';
const NAME        = 'wlan1';
#[AsCommand(name: NAME, description: DESCRIPTION)]

final class Command extends MLSCCommand
{
    use Lang;

    public $CommandArguments = [
        ['event', 'REQUIRED', 'wireless event'],
        ['macid', 'OPTIONAL', 'data string']
    ];
}
