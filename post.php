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

    <link rel="stylesheet" type="text/css" href="/assets/main.css">

    <?php
    if (isset($_GET['id'])) {
        $post = getPost($_GET['id']);
    } else {
        header("Location: index.php");
    }
    ?>

    <title><?= $post->id . " by @" . $post->author->name . " — " . $site_title; ?></title>

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
    <div class="warning">
        You're viewing a single post. <a href="/">Return to timeline</a>
    </div>
    <?php showPost($post) ?>
</body>
</html>