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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="/assets/webmention.min.js" async></script>

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
    <section>
        <h2>Webmentions</h2>

        <div id="webmentions"></div>
        
        <form action="https://webmention.io/geheimesite.nl/webmention" method="post">
            <p>This post accepts <a href="https://webmention.net">webmentions</a>. Let me know the URL of your <a href="https://indieweb.org/responses">response</a>:</p>

            <input type="url" name="source">
            <input type="hidden" name="target" value="<?= $post->uri ?>">
            <input type="submit" class="ui submit button" value="Send Webmention">
        </form>
    </section>
</body>
</html>