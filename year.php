<?php
// Template for rendering all posts from a year

require "config.php";
require "utils.php";
?>
<!DOCTYPE html>
<html lang="<?= $site_language ?>">
<head>
    <?php include "partials/head.php" ?>

    <?php
    if (isset($_GET['year'])) {
        $year = $_GET['year'];

        if(!isValidYear($year)) {
            header("Location: /");
        } 

    } else {
        header("Location: /");
    }
    ?>

    <title><?= "Posts from $year — $site_title" ?></title>
</head>
<body>
    <main>
        <?php include "partials/header.php" ?>
        <?php showWarning("You're viewing posts from $year.") ?>
        <?php listPosts($year) ?>
    </main>
    <aside>
        <?php include "partials/sidebar.php" ?>
    </aside>
</body>
</html>