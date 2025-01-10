<?php

/**
 * Command like Metatag writer for video files.
 */

namespace MLSC\Modules\HTTP;

use MLSC\Core\MLSC;
use Symfony\Component\HttpClient\HttpClient;

class HTTP
{
    public $client;

    public const SYSTEM_URL   = '/api/system/devices';

    public const SETTINGS_URL = '/api/settings/device';
    public const UDP_URL      = '/api/settings/device/output-type';
    public const EFFECT_URL   = '/api/settings/effect';
    public const ACTIVE_URL   = '/api/effect/active';
    public const EFFECTS_URL  = '/api/resources/effects';


    public function __construct()
    {
    }

    public static function __callStatic($method, $args)
    {
        $method = strtolower($method);
        if (str_starts_with($method, 'get'))
        {
            $prefix = 'get';
            $query  = 'GET';
        }
        if (str_starts_with($method, 'set'))
        {
            $prefix = 'set';
            $query  = 'POST';
        }

        if (isset($prefix))
        {
            $method   = substr($method, 3);

            $constant = strtoupper($method).'_URL';
            $url      = __HTTP_HOST__. self::{$constant};

            $method   = $prefix.'Response';
            return self::$method($query, $url, $args);
        }
    }

    public static function getResponse($query, $url, $data = [])
    {
        $params      = [];
        if (count($data) > 0)
        {
            if (is_array($data))
            {
                $params = ['query' => $data[0]];
            }
        }

        $client      = HttpClient::create();
        $response    = $client->request(strtoupper($query), $url, $params);
        $statusCode  = $response->getStatusCode();
        $contentType = $response->getHeaders();

        $response    = $response->toArray();
        // utmdump([__METHOD__, $statusCode]);
        return $response;
    }

    public static function setResponse($query, $url, $data = [])
    {
        $params      = ['json' => []];
        if (isset($data[0]))
        {
            $params = $data[0];
        }
        $client      = HttpClient::create();
        // MLSC::$console->writeln(__LINE__." -> :".$query. ' ' .$url . ' '.var_export($params, 1));
        utmdump([$query, $url, $params]);

        $response    = $client->request(strtoupper($query), $url, $params);
        $statusCode  = $response->getStatusCode();
        $contentType = $response->getHeaders();

        $response    = $response->toArray();
        return $response;
    }
}
