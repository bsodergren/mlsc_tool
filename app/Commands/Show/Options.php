<?php


namespace MLSC\Commands\Show;

use MLSC\Core\MLSCOptions;
use MLSC\Traits\Translate;
use Symfony\Component\Console\Input\InputOption;

class Options extends MLSCOptions
{
    use Lang;

    // public $options                          = ['Default'];

    public function Definitions()
    {
        Translate::$Class = __CLASS__;
        return [
            ['deviceid', 'D', InputOption::VALUE_REQUIRED, Translate::text('L__BACKUP_DIRECTORY')],
        ];
    }
}
