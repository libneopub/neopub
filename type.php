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
    <?php include "partials/head.php" ?>
    
    <?php
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
        $typePlural = $pluralLookup[$type];
    } else {
        header("Location: /");
    }
    ?>

    <title><?= "All " . $typePlural . " — " . $site_title; ?></title>
</head>
<body>
    <main>
        <?php include "partials/header.php" ?>
        <div class="warning">
            You're viewing all <?= $typePlural ?>. <a href="/">Return to timeline</a>
        </div>
        <?php listPostsOfType($current_year, $type) ?>
    </main>
    <aside>
        <?php include "partials/sidebar.php" ?>
    </aside>
</body>
</html>