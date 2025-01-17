<?php

namespace MLSC\Traits\Device;

use MLSC\Modules\HTTP\HTTP;
use MLSC\Modules\HTTP\Json;

trait Add
{
    public function addDevice($ip)
    {
        $result      = HTTP::setSystem();
        $device_key  = str_replace('device_', '', $result['device_id']);
        $box_id      = (int) $device_key - 4;
        $device_name = 'Box '.(string) $box_id;
        $params      = ['device'      => $result['device_id'],
            'settings'                => ['device_name' =>  $device_name]];
        $result2 = HTTP::setSettings(['json' => Json::parse('settings', $params)]);

        $params = ['device'       => $result['device_id'],
            'settings'            => ['udp_client_ip' => $ip]];
        $result3 = HTTP::setUDP(['json' => Json::parse('network', $params)]);

        return [$result['device_id'], $device_name];
    }
}
