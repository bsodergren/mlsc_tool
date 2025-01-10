<?php

namespace MLSC\Traits;

use MLSC\Core\MLSC;
use MLSC\Modules\Wifi\WiFi;

trait wLanProcess
{
    public function exec($option = null)
    {
        $wifi        = new WiFi();
        $eventMethod = MLSC::$input->getArgument('event');
        $macid       = MLSC::$input->getArgument('macid');
        $method      = str_replace('-', '_', $eventMethod);

        $wifi->{$method}($macid);
    }
}
