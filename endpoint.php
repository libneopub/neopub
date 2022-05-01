<?php
// Webmention endpoint for creating new posts (micropub)

// Licensed under a CC0 1.0 Universal (CC0 1.0) Public Domain Dedication
// http://creativecommons.org/publicdomain/zero/1.0/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "config.php";
require "utils.php";

$_HEADERS = array();
foreach (getallheaders() as $name => $value) {
    $_HEADERS[$name] = $value;
}

if (!isset($_HEADERS['Authorization'])) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 401 Unauthorized');
    echo 'Missing "Authorization" header.';
    exit;
}
if (!isset($_POST['h'])) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    echo 'Missing "h" value.';
    exit;
}

$options = array(
    CURLOPT_URL => $token_endpoint,
    CURLOPT_HTTPGET => TRUE,
    CURLOPT_USERAGENT => $site_url,
    CURLOPT_TIMEOUT => 5,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HEADER => FALSE,
    CURLOPT_HTTPHEADER => array(
        'Content-type: application/x-www-form-urlencoded',
        'Authorization: ' . $_HEADERS['Authorization']
    )
);

$curl = curl_init();
curl_setopt_array($curl, $options);
$source = curl_exec($curl);
curl_close($curl);

parse_str($source, $values);

if (!isset($values['me'])) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    echo 'Missing "me" value in authentication token.';
    exit;
}
if (!isset($values['scope'])) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    echo 'Missing "scope" value in authentication token.';
    exit;
}
if (substr($values['me'], -1) != '/') {
    $values['me'] .= '/';
}
if (substr($site_domain, -1) != '/') {
    $site_domain .= '/';
}
if (strtolower($values['me']) != strtolower($site_domain)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
    echo 'Mismatching "me" value in authentication token.';
    
    echo "Expected: " . strtolower($values['me']);
    echo "Got: " . strtolower($site_domain);
    exit;
}
if (!stristr($values['scope'], 'create')) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
    echo 'Missing "create" value in "scope".';
    exit;
}
if (!isset($_POST['content'])) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    echo 'Missing "content" value.';
    exit;
}

/* Everything's cool. Do something with the $_POST variables
(such as $_POST['content'], $_POST['category'], $_POST['location'], etc.)
e.g. create a new entry, store it in a database, whatever. */

header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
print_r($_POST);

print_r($_POST['category']);

$file = fopen("log.json", 'w+');
fwrite($file, json_encode($_POST));
fclose($file);

exit;

if(isset($_POST['in-reply-to'])) {
    newReply($_POST['content'], $_POST['in-reply-to']);
} 
else if(isset($_POST['repost-of'])) {
    newRepost($_POST['repost-of'], $_POST['category']);
}
else if(isset($_POST['like-of'])) {
    newLike($_POST['like-of'], $_POST['category']);
} 
else if(isset($_POST['bookmark-of'])) {
    newBookmark($_POST['content'], $_POST['bookmark-of'], $_POST['name'], $_POST['category']);
}
else {
    newNote($_POST['content'], $_POST['category']);
}

header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
header('Location: ' . $site_url);
