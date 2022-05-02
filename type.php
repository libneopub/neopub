<?php
// Template for rendering the type/category pages

require "config.php";
require "utils.php";

$pluralLookup = [
    "note" => "notes",
    "reply" => "replies", 
    "like" => "likes", 
    "bookmark" => "bookmarks", 
    "repost" => "reposts"
];
?>
<!DOCTYPE html>
<html lang="<?= $site_language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="/assets/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
        $typePlural = $pluralLookup[$type];
    } else {
        header("Location: index.php");
    }
    ?>

    <title><?= "All " . $typePlural . " — " . $site_title; ?></title>

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
    <main>
        <?php include "partials/header.php" ?>
        <div class="warning">
            You're viewing all <?= $typePlural ?>. <a href="/">Return to timeline</a>
        </div>
        <?php listPostsOfType($type) ?>
    </main>
    <aside>
        <?php include "partials/sidebar.php" ?>
    </aside>
</body>
</html>