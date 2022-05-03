<?php
// Template for rendering the tag pages

require "config.php";
require "utils.php";
?>
<!DOCTYPE html>
<html lang="<?= $site_language ?>">
<head>
    <?php include "partials/head.php" ?>

    <?php
    if (isset($_GET['tag'])) {
        $tag = $_GET['tag'];
    } else {
        header("Location: /");
    }
    ?>

    <title><?= "Posts tagged \"" . $tag . "\" — " . $site_title; ?></title>
</head>
<body>
    <main>
        <?php include "partials/header.php" ?>
        <div class="warning">
            You're viewing all posts tagged "<?= $tag ?>". <a href="/">Return to timeline</a>
        </div>
        <?php listPostsWithTag($currentYear, $tag) ?>
    </main>
    <aside>
        <?php include "partials/sidebar.php" ?>
    </aside>
</body>
</html>