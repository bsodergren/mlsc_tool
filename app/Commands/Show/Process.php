<?php

/**
 * CWP Media tool
 */

namespace MLSC\Commands\Show;

use MLSC\Core\MLSC;
use UTM\Utilities\Option;
use MLSC\Modules\Device\Device;
use MLSC\Modules\Effects\Effects;

class Process extends MLSC
{
    public function init()
    {
        return $this;
    }

    public function exec($option = null)
    {


        $showType = MLSC::$input->getArgument('item');
  $typeName       = MLSC::$input->getArgument('name');
  $device_id = Device::clean(Option::getValue("deviceid"));
        if($showType == "effects"){
            $effects = new Effects();
            $effects->getAllEffects();
        }
        if($showType == "effect"){
            $effects = new Effects($device_id);
            $effects-> getEffect($typeName);
        }

                 utmdd([$showType , $device_id,$typeName ] );


        MLSC::$console->writeln($showType , $device_id,$typeName );
       


        // MLSC::$console->writeln($macid);
                utmdd("fdsasd");
    }
}
