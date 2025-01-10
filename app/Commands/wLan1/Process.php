<?php

/**
 * Command like Metatag writer for video files.
 */

namespace MLSC\Commands\wLan1;

use MLSC\Core\MLSC;
use MLSC\Traits\wLanProcess;

class Process extends MLSC
{
    use wLanProcess;

    public function init()
    {
        return $this;
    }
}
