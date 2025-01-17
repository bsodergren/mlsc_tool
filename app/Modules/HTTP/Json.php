<?php

namespace MLSC\Modules\HTTP;

use Symfony\Component\Filesystem\Filesystem;

class Json
{
    public $json_dir = __JSON_SETTINGS__;

    public static function parse($json, $params)
    {
        $json_file = __JSON_SETTINGS__.\DIRECTORY_SEPARATOR.'device_'.$json.'.json';

        $filesystem = new Filesystem();

        $contents = json_decode($filesystem->readFile($json_file), 1);

        $contents = array_replace_recursive($contents, $params);

        return $contents;
    }
}
