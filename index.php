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
    <div class="h-card" rel="author" id="author">
        <div>
            <img class="u-photo" id="author-img" alt="profile picture" src="assets/me.jpeg">
            <div id="card" class="md">
                <h1 class="p-name"><?= $site_author ?></h1>
                <address class="properties">
                    <a class="u-url u-uid" href="https://geheimesite.nl">https://geheimesite.nl</a> ∙ 
                    <a rel="me" href="https://github.com/<?= $github_user ?>">github</a> ∙
                    <a rel="me" href="https://micro.blog/Robijntje">Micro.blog</a> 
                </address>
                <p class="p-note">

                </p>
            </div>
        </div>
    </div>
    <?php listPosts() ?>
</body>
</html>