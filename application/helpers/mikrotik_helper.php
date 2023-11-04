<?php

defined('BASEPATH') or exit('No direct script access allowed');

function formatBytes($bytes, $decimal = null)
{
    $satuan = ["bytes", 'kb', 'mb', 'gb', 'tb'];
    $i = 0;

    while ($bytes > 1024) {
        $bytes /= 1024;
        $i++;
    }

    return round($bytes, $decimal) . " " . $satuan[$i];
}

function connectKraksaaan()
{
    $CI = &get_instance();

    $ipMikrotik         = '103.189.60.31:8003';
    $usernameMikrotik   = 'infly';
    $passwordMikrotik   = 'infly2023';


    $api = new RouterosAPI();
    $api->connect($ipMikrotik, $usernameMikrotik, $passwordMikrotik);

    if (count($api->comm('/ppp/secret/print')) == 0) {
        echo json_encode("Connection Failed");
        exit;
    }

    return $api;
}

function connectPaiton()
{
    $CI = &get_instance();

    $ipMikrotik         = '103.189.60.33:8003';
    $usernameMikrotik   = 'infly';
    $passwordMikrotik   = 'infly2023';


    $api = new RouterosAPI();
    $api->connect($ipMikrotik, $usernameMikrotik, $passwordMikrotik);

    if (count($api->comm('/ppp/secret/print')) == 0) {
        echo json_encode("Connection Failed");
        exit;
    }

    return $api;
}
