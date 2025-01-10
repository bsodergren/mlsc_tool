<?php

/**
 * Command like Metatag writer for video files.
 */

namespace MLSC\Commands\Delete;

use MLSC\Core\MLSCOptions;
use MLSC\Traits\Translate;
use Symfony\Component\Console\Input\InputOption;

class Options extends MLSCOptions
{
    use Lang;

    // public $options                          = ['Default'];

    // public function Definitions()
    // {
    //     Translate::$Class = __CLASS__;
    //     return [
    //         ['device_id', 'D', InputOption::VALUE_REQUIRED, Translate::text('L__BACKUP_DIRECTORY')],
    //     ];
    // }
}
