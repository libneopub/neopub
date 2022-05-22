<?php
// Provides util functions for tasks

require "config.php";
require "utils/posts.php";
require "utils/render.php";
require "utils/mentions.php";
require "utils/uploader.php";

$currentYear = date("Y");

// Misc utils

// Method to debug the micropub endpoint
// It crashes the endpoint and logs the 
// request to log.json
function debugEndpoint() 
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    print_r($_POST);

    $file = fopen('log.json', 'w+');
    fwrite($file, json_encode($_POST));
    fclose($file);

    exit;
}

// Check wether a string is a
// valid year.
function isValidYear($year) {
    return !strtotime($year) === false;
}