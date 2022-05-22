<?php
// Webmention endpoint for creating new posts (micropub)

// Licensed under a CC0 1.0 Universal (CC0 1.0) Public Domain Dedication
// http://creativecommons.org/publicdomain/zero/1.0/

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

/* Everything's cool. Do something with the $_POST variables
(such as $_POST['content'], $_POST['category'], $_POST['location'], etc.)
e.g. create a new entry, store it in a database, whatever. */

// debugEndpoint();

if(isset($_POST['in-reply-to'])) {
    $post = newReply($_POST['content'], $_POST['in-reply-to']);
    $url = publishPost($post);
    sendWebmentions($url);
} 
else if(isset($_POST['repost-of'])) {
    $post = newRepost($_POST['repost-of']);
    $url = publishPost($post);
    sendWebmentions($url);
}
else if(isset($_POST['like-of'])) {
    $post = newLike($_POST['like-of']);
    $url = publishPost($post);
    sendWebmentions($url);
} 
else if(isset($_POST['bookmark-of'])) {
    $post = newBookmark($_POST['content'], $_POST['bookmark-of'], $_POST['name'], $_POST['category']  || array());
    $url = publishPost($post);
    sendWebmentions($url);
}
else if(isset($_FILES['photo'])) {
    $file_path = $_FILES['photo']['tmp_name'];
    $file_url = uploadFileToGitHub($file_path, uniqid('IMG_'));
    $post = newPhoto($file_url, $_POST['content'], $_POST['category'] || array());
    $url = publishPost($post);
    sendWebmentions($url);
}
else {
    $post = newNote($_POST['content'], $_POST['category']  || array());
    $url = publishPost($post);
    sendWebmentions($url);
}

header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
header('Location: ' . $url);
