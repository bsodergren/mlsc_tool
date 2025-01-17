<?php

namespace MLSC\Modules\Device;

use MLSC\Modules\HTTP\HTTP;
use MLSC\Traits\Device\Add;
use MLSC\Traits\Device\Delete;
use MLSC\Traits\Device\Get;
use MLSC\Traits\Device\Set;
use MLSC\Traits\Device\Update;

class Device
{
    use Add;
    use Delete;
    use Get;
    use Set;
    use Update;

    public $devices = [];

    public $device_id = '';
    public $settings  = [];

    public function __construct()
    {
        $this->getAllDevices();
    }

    public static function clean($string)
    {
        if (!preg_match('(device)', $string)) {
            $string = 'device_'.$string;
        }

        return $string;
    }

    public function ipExists($ip)
    {
        foreach ($this->devices as $id => $device) {
            if ($ip == $device['ip']) {
                return true;
            }
        }

        return false;
    }

    public function getAllDevices()
    {
        if (0 == \count($this->devices)) {
            $this->devices = HTTP::getSystem();

            foreach ($this->devices as $k => $device) {
                $settings              = $this->getDeviceInfo($device['id']);
                $devices[$k]['id']     = $this->devices[$k]['id'];
                $devices[$k]['device'] = $settings['device'];
                $devices[$k]['name']   = $this->devices[$k]['name'];
                $devices[$k]['ip']     = $settings['setting_value']['output_udp']['udp_client_ip'];
            }
            $this->devices = $devices;
        }
    }

    public function getDeviceInfo($device_id)
    {
        self::clean($device_id);
        $data = [
            'device'      => $device_id,
            'setting_key' => 'output',
        ];

        return HTTP::getSettings($data);
    }
}
