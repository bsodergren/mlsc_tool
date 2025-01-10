<?php

namespace MLSC\Config;

use MLSC\Commands\Add\Command as AddCommand;
use MLSC\Commands\Show\Command as ShowCommand;
use MLSC\Commands\Reset\Command as ResetCommand;
use MLSC\Commands\wLan0\Command as wLan0Command;
use MLSC\Commands\wLan1\Command as wLan1Command;
use MLSC\Commands\Delete\Command as DeleteCommand;
use MLSC\Commands\Update\Command as UpdateCommand;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;

return new FactoryCommandLoader([
        'show'   => function ()
        { return new ShowCommand(); },
        'add'    => function ()
        {return new AddCommand(); },
        'update' => function ()
        { return new UpdateCommand(); },

        'delete' => function ()
        { return new DeleteCommand(); },
        'wlan0'  => function ()
        { return new wLan0Command(); },
        'wlan1'  => function ()
        { return new wLan1Command(); },
        'reset'  => function ()
        { return new ResetCommand(); },
    ]);
