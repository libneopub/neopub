<?php
// Reusable sidebar component

require "config.php";
?>

<section class="sidebar-section">
    <nav>
        <ul>
            <li><a class="home" href="/">home</a></li>
            <li><a class="replies" href="/type/reply">replies</a></li>
            <li><a class="notes" href="/type/note">notes</a></li>
            <li><a class="likes" href="/type/like">likes</a></li>
            <li><a class="reposts" href="/type/repost">reposts</a></li>
            <li><a class="bookmarks" href="/type/bookmark">bookmarks</a></li>
            <li><a class="photos" href="/tag/photo">photos</a></li>
        </ul>
    </nav>
</section>

<section class="sidebar-section about">
    <h3>About me</h3>
    <p>
        <?= $site_description ?>
    </p>
</section>