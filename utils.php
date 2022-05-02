<?php
// Utils for getting and creating posts

require "vendor/autoload.php";

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

function newRepost($repostof)
{
    global $site_url;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;

    $post = array(
        "type" => "repost",
        "repost-of" => $repostof,
        "date" => date("Y-m-d H:i:s"),
        "id" => $id,
        "uri" => $url
    );

    writePost($post);
}

function newLike($likeof)
{
    global $site_url;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;

    $post = array(
        "type" => "like",
        "like-of" => $likeof,
        "date" => date("Y-m-d H:i:s"),
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

    array_unshift($posts, $post);

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
                <p class="e-content p-summary">
                    <?= $post->content ?>
                </p>

                <a class="no-underline u-url" href="<?= $post->uri ?>">
                    <time class="dt-published"><?= $post->date ?></time>
                </a>
            </div>
        </article>
    <?php

    } else if ($post->type == "reply") {

    ?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>

            <div>
                <div class="e-content">
                    <p class="p-name">
                        <i class="fa-solid fa-reply"></i> replied to 
                        <a href="<?= $post->{'in-reply-to'} ?>" class="u-in-reply-to"><?= $post->{'in-reply-to'} ?></a>
                    </p>
                    <p class="p-summary">
                        <?= $post->content ?>
                    </p>
                </div>           

                <a class="no-underline u-url" href="<?= $post->uri ?>">
                    <time class="dt-published"><?= $post->date ?></time>
                </a>
            </div>
        </article>
    <?php

    } else if ($post->type == "repost") {

    ?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>

            <div>
                <p class="e-content p-name">
                    <i class="fa-solid fa-arrows-spin"></i> reposted 
                    <a href="<?= $post->{'repost-of'} ?>" class="u-repost-of h-cite"><?= $post->{'repost-of'} ?></a>
                </p>

                <a class="no-underline u-url" href="<?= $post->uri ?>">
                    <time class="dt-published"><?= $post->date ?></time>
                </a>
            </div>
        </article>
    <?php

    } else if ($post->type == "like") {

        ?>
            <article class="h-entry">
                <?php include "partials/author.php" ?>
    
                <div>
                    <p class="e-content p-name">
                        <i class="fa-solid fa-heart"></i> liked 
                        <a href="<?= $post->{'like-of'} ?>" class="u-like-of h-cite"><?= $post->{'like-of'} ?></a>
                    </p>
    
                    <a class="no-underline u-url" href="<?= $post->uri ?>">
                        <time class="dt-published"><?= $post->date ?></time>
                    </a>
                </div>
            </article>
        <?php
    
    } else if ($post->type == "bookmark") {

    ?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>

            <div>
                <div class="e-content">
                    <p class="p-name">
                        <i class="fa-solid fa-bookmark"></i> 
                        <a href="<?= $post->{'bookmark-of'} ?>" class="u-bookmark-of h-cite"><?= $post->{'bookmark-of'} ?></a>
                    </p>

                    <p class="p-summary">
                        <?= $post->content ?>
                    </p>
                </div>

                <a class="no-underline u-url" href="<?= $post->uri ?>">
                    <time class="dt-published"><?= $post->date ?></time>
                </a>
            </div>
        </article>
    <?php

    }
}

function debugEndpoint() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    print_r($_POST);

    $file = fopen("log.json", 'a');
    fwrite($file, json_encode($_POST));
    fclose($file);

    exit;
}

function sendWebmentions() {
    global $site_url;

    $client = new IndieWeb\MentionClient();
    $sent = $client->sendMentions($site_url);

    $file = fopen("log.json", 'a');
    fwrite($file, "Sent $sent mentions\n");
    fclose($file);
}
?>