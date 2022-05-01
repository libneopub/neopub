<?php
require "config.php";
require "utils.php";
?>
<!DOCTYPE html>
<html lang="<?= $site_language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="assets/main.css">

    <title><?= $site_title; ?></title>

    <link rel="alternate" type="application/rss+xml" title="<?= $site_title ?>" href="<?= $site_url . "/content/feed" ?>" />
    
    <!-- Micro{sub, pub} -->
    <link rel="microsub" href="<?= $microsub ?>">
    <link rel="micropub" href="/endpoint.php" />   

    <!-- IndieAuth -->
    <link rel="authorization_endpoint" href="<?= $authorization_endpoint ?>">
    <link rel="token_endpoint" href="<?= $token_endpoint ?>">
    <link rel="me" href="https://github.com/<?= $github_user ?>" />

    <!-- Webmention -->
    <link rel="webmention" href="<?= $webmention_endpoint ?>" />
    <link rel="pingback" href="<?= $pingback ?>" />
</head>
<body>
    <?php include "partials/header.php" ?>
    <?php listPosts() ?>
</body>
</html>