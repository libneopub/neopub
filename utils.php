<?php
// Utils for getting and creating posts

require "config.php";

function newNote($content, $categories)
{
    global $site_url;
    global $site_author;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;
    $author = array("name" => $site_author);

    $post = array(
        "type" => "note",
        "author" => $author,
        "categories" => $categories,
        "content" => $content,
        "date" => date("Y-m-d H:i:s"),
        "site" => $site_url,
        "tags" => $categories,
        "id" => $id,
        "uri" => $url
    );

    writePost($post);
}

function newReply($content, $replyto)
{
    global $site_url;
    global $site_author;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;
    $author = array("name" => $site_author);

    $post = array(
        "type" => "reply",
        "in-reply-to" => $replyto,
        "author" => $author,
        "content" => $content,
        "date" => date("Y-m-d H:i:s"),
        "site" => $site_url,
        "id" => $id,
        "uri" => $url
    );

    writePost($post);
}

function newRepost($repostof, $categories)
{
    global $site_url;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;

    $post = array(
        "type" => "repost",
        "repost-of" => $repostof,
        "categories" => $categories,
        "date" => date("Y-m-d H:i:s"),
        "tags" => $categories,
        "id" => $id,
        "uri" => $url
    );


    writePost($post);
}

function newLike($likeof, $categories)
{
    global $site_url;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;

    $post = array(
        "type" => "like",
        "like-of" => $likeof,
        "categories" => $categories,
        "date" => date("Y-m-d H:i:s"),
        "tags" => $categories,
        "id" => $id,
        "uri" => $url
    );


    writePost($post);
}

function newBookmark($content, $bookmarkof, $title, $categories)
{
    global $site_url;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;

    $post = array(
        "type" => "bookmark",
        "bookmark-of" => $bookmarkof,
        "categories" => $categories,
        "content" => $content,
        "date" => date("Y-m-d H:i:s"),
        "tags" => $categories,
        "name" => $title,
        "id" => $id,
        "uri" => $url
    );

    writePost($post);
}

function writePost($post)
{
    $posts_json = file_get_contents("content/feed.json");
    $posts = json_decode($posts_json);

    array_push($posts, $post);

    $file = fopen("content/feed.json", 'w+');
    fwrite($file, json_encode($posts));
    fclose($file);
}

function getPost($id)
{
    $posts_json = file_get_contents("content/feed.json");
    $posts = json_decode($posts_json);

    foreach ($posts as $post) {
        if ($post->id === $id) {
            return $post;
        }
    }
}

function listPosts() {
    $posts_json = file_get_contents("content/feed.json");
    $posts = json_decode($posts_json);

    foreach ($posts as $post) {
        showPost($post);
    }
}

function showPost($post)
{
    if ($post->type === "note") {

?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>

            <div>
                <p class="p-content p-name p-summary">
                    <?= $post->content ?>
                </p>

                <time class="dt-published"><?= $post->date ?></time>
            </div>
        </article>
    <?php

    } else if ($post->type == "reply") {

    ?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>

            <div>
                <div class="p-content">
                    <p class="p-name">🗩 Reply to <a href="<?= $post->in_reply_to ?>" class="u-in-reply-to"><?= $post->in_reply_to ?></a></p>
                    <p class="p-summary">
                        <?= $post->content ?>
                    </p>
                </div>           

                <time class="dt-published"><?= $post->date ?></time>
            </div>
        </article>
    <?php

    } else if ($post->type == "repost") {

    ?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>

            <div>
                <p class="p-content p-name">
                    🔥 Repost of <a href="<?= $post->repost_of ?>" class="u-repost-of h-cite"><?= $post->repost_of ?></a>
                </p>

                <time class="dt-published"><?= $post->date ?></time>
            </div>
        </article>
    <?php

    } else if ($post->type == "like") {

        ?>
            <article class="h-entry">
                <?php include "partials/author.php" ?>
    
                <div>
                    <p class="p-content p-name">
                        ❤️ Like of <a href="<?= $post->like_of ?>" class="u-like-of h-cite"><?= $post->like_of ?></a>
                    </p>
    
                    <time class="dt-published"><?= $post->date ?></time>
                </div>
            </article>
        <?php
    
    } else if ($post->type == "bookmark") {

    ?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>

            <div>
                <div class="p-content">
                    <p class="p-name">
                        🔖 Bookmark of <a href="<?= $post->bookmark_of ?>" class="u-bookmark-of h-cite"><?= $post->name ?></a>
                    </p>

                    <p class="p-summary">
                        <?= $post->content ?>
                    </p>
                </div>

                <time class="dt-published"><?= $post->date ?></time>
            </div>
        </article>
    <?php

    }
}

function debugEndpoint() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    print_r($_POST);

    $file = fopen("log.json", 'w+');
    fwrite($file, json_encode($_POST));
    fclose($file);

    exit;
}

?>