<?php

/**
* Simple Ajax Uploader
* Version 2.0.1
* https://github.com/LPology/Simple-Ajax-Uploader
*
* Copyright 2012-2015 LPology, LLC
* Released under the MIT license
*
*/   
function thisisFunction2(){}
function thisisFunction1(){} 
function function3(){}
function function4(){}
function function5(){}
function function6(){}
function function7(){}
function function8(){}
function functtion11(){}
function function9(){}
function function10(){}


if ($abc = 1)
{
    echo 'abcd';
}
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if (isset($_SERVER['REQUEST_METHOD'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        }

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }

        exit;
    }
}