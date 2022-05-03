<?php
// Template for rendering a single post

require "config.php";
require "utils.php";
?>
<!DOCTYPE html>
<html lang="<?= $site_language ?>">
<head>
    <?php include "partials/head.php" ?>

    <script src="/assets/webmention.min.js" async></script>

    <?php
    if (isset($_GET['year']) && isset($_GET['id'])) {
        $post = getPost($_GET['year'], $_GET['id']);
        $notFound = !isset($post);

    } else {
        header("Location: /");
    }
    ?>

    <title>
        <?php
        if(!$notFound) {
            echo "$post->id by @".$post->author->name." — $site_title";
        } else {
            echo "Post not found — $site_title";
        }
        ?>
    </title>
</head>
<body>
    <main>
        <?php 
        include "partials/header.php";
        
        if(!$notFound) {
            showPost($post);
            include "partials/comment-section.php";
        } else {
            showError("This post doesn't exist (anymore)");
        }
        ?>
    </main>
    <aside>
        <?php include "partials/sidebar.php" ?>
    </aside>
</body>
</html>