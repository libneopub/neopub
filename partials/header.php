<?php
// Reusable header component with site author h-card

require "config.php";

$current_year = date("Y");
?>

<header class="h-card" rel="author" id="author">
    <div>
        <img class="u-photo" id="author-img" alt="profile picture" src="<?= $site_author_profile_picture ?>">
        <div id="card" class="md">
            <h1 class="p-name"><?= $site_author ?></h1>
            <address class="properties">
                <a rel="me" class="u-url u-uid" href="<?= $site_domain ?>"><?= $site_domain ?></a> ∙ 
                <?php if($github_user !== "") { ?>
                    <a rel="me" href="https://github.com/<?= $github_user ?>">github</a> ∙
                <?php } ?>
                <?php if($twitter_user !== "") { ?>
                    <a rel="me" href="https://twitter.com/<?= $twitter_user ?>">twitter</a> ∙
                <?php } ?>
                <a href="/content/<?= $current_year ?>.json">json</a> ∙
                <a href="/feed">rss</a> 
            </address>
            <p class="p-note" hidden>
                <?= $site_description ?>
            </p>
        </div>
    </div>
</header>