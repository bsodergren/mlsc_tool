<?php

namespace MLSC\Modules\Wifi;

use MLSC\Core\MLSC;
use MLSC\Modules\Device\Device;
use MLSC\Modules\Exec\Executable;
use MLSC\Traits\Callables;
use Nette\Utils\Callback;

class WiFi
{
    use Callables;

    public $exec;
    public $device;
    public $ip;

    public function __construct()
    {
        $this->exec   = new Executable();
        $this->device = new Device();
    }

    public function __call($method, $args)
    {
        dd(['call', $method, $args]);
    }

    public function AP_STA_CONNECTED($macId = '')
    {
        $callback = Callback::check([$this, 'getIpfromNeighbor']);
        $this->exec->addOptionArg('neighbor');
        $this->macid = $macId;
        // $this->exec->macid = $macId;

        $this->exec->setCommand('ip');
        // $process->macid = $macId;

        $this->exec->exec($callback);

        MLSC::$console->writeln($this->ip);

        if (!$this->device->ipExists($this->ip)) {
            $device_id = $this->device->addDevice($this->ip);
            utmdd($device_id);

            // $device_id   = [0 => 'device_5', 1 => 'Box 1'];
            // $this->device->setBrightness('50');
        }
        utmdd('ip exist');

        //        |grep "'.$mac_id.'" | cut -d" " -f1
    }

    public function AP_STA_DISCONNECTED($macId = '')
    {
        dd(__METHOD__, $macId);
    }
}
