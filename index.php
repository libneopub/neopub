<?php
// Template for the homepage

require "config.php";
require "utils.php";
?>
<!DOCTYPE html>
<html lang="<?= $site_language ?>">
<head>
    <?php include "partials/head.php" ?>
    <title><?= $site_title; ?></title>
</head>
<body>
    <main>
        <?php include "partials/header.php" ?>
        <?php listPosts($currentYear) ?>
    </main>
    <aside>
        <?php include "partials/sidebar.php" ?>
    </aside>
    <footer>
        <?php include "partials/footer.php" ?>
    </footer>
</body>
</html>