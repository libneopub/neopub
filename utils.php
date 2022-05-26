<?php
// Provides util functions for tasks

require __DIR__."/config.php";
require __DIR__."/utils/posts.php";
require __DIR__."/utils/render.php";
require __DIR__."/utils/mentions.php";
require __DIR__."/utils/uploader.php";

$currentYear = date("Y");

// Misc utils

// Method to debug the micropub endpoint
// It crashes the endpoint and logs the 
// request to log.json
function debugEndpoint() 
{
    header($_SERVER['SERVER_PROTOCOL'] . " 400 Bad Request");
    echo "You sent:\n";
    print_r($_POST);

    $file = fopen(__DIR__."/log.json", "w+");
    fwrite($file, json_encode($_POST));
    fclose($file);

    exit;
}

// Check wether a string is a
// valid year.
function isValidYear($year) {
    return !strtotime($year) === false;
}