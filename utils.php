<?php
// Utils for getting and creating posts

require "vendor/autoload.php";
use Michelf\Markdown;
require "config.php";

// Method to generate a new 
// note. Returns the note.
function newNote($content, $categories)
{
    global $site_url;
    global $site_author;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;
    $author = array("name" => $site_author);

    $content = Markdown::defaultTransform($content);

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

    return $post;
}

// Method to generate a new 
// reply. Returns the reply.
function newReply($content, $replyto)
{
    global $site_url;
    global $site_author;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;
    $author = array("name" => $site_author);

    $content = Markdown::defaultTransform($content);

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

    return $post;
}

// Method to generate a new 
// repost. Returns the post.
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

    return $post;
}

// Method to generate a new 
// like. Returns the post.
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

    return $post;
}

// Method to generate a new 
// bookmark. Returns the post.
function newBookmark($content, $bookmarkof, $title, $categories)
{
    global $site_url;

    $id = uniqid();
    $url = $site_url . "/post/" . $id;

    $content = Markdown::defaultTransform($content);

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

    return $post;
}

// Method to write a post
// to the feed.json file (or database)
// Returns the URI of the published post.
function publishPost($post)
{
    $posts_json = file_get_contents("content/feed.json");
    $posts = json_decode($posts_json);

    array_unshift($posts, $post);

    $file = fopen('content/feed.json', 'w+');
    fwrite($file, json_encode($posts));
    fclose($file);

    return $post["uri"];
}

// Method to get post by its ID
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

// Method to loop trough all posts
// and render them
function listPosts() {
    $posts_json = file_get_contents("content/feed.json");
    $posts = json_decode($posts_json);

    foreach ($posts as $post) {
        showPost($post);
    }
}

// Method to render a single post
function showPost($post)
{
    if ($post->type === "note") {

    ?>
        <article class="h-entry">
            <div>
                <div class="e-content p-summary">
                    <?= $post->content ?>
                </div>

                <a class="no-underline u-url" href="<?= $post->uri ?>">
                    <time class="dt-published"><?= $post->date ?></time>
                </a>
            </div>

            <?php include "partials/author.php" ?>
        </article>
    <?php

    } else if ($post->type == "reply") {

    ?>
        <article class="h-entry">
            <div>
                <div>
                    <p class="p-name">
                        <i class="fa-solid fa-reply"></i> replied to 
                        <a class="u-in-reply-to" href="<?= $post->{'in-reply-to'} ?>"><?= $post->{'in-reply-to'} ?></a>
                    </p>
                    <div class="p-summary e-content">
                        <?= $post->content ?>
                    </div>
                </div>           

                <a class="no-underline u-url" href="<?= $post->uri ?>">
                    <time class="dt-published"><?= $post->date ?></time>
                </a>
            </div>

            <?php include "partials/author.php" ?>
        </article>
    <?php

    } else if ($post->type == "repost") {

    ?>
        <article class="h-entry">
            <div>
                <p class="e-content p-name">
                    <i class="fa-solid fa-arrows-spin"></i> reposted 
                    <a class="u-repost-of h-cite" href="<?= $post->{'repost-of'} ?>"><?= $post->{'repost-of'} ?></a>
                </p>

                <a class="no-underline u-url" href="<?= $post->uri ?>">
                    <time class="dt-published"><?= $post->date ?></time>
                </a>
            </div>

            <?php include "partials/author.php" ?>
        </article>
    <?php

    } else if ($post->type == "like") {

        ?>
            <article class="h-entry">   
                <div>
                    <p class="e-content p-name">
                        <i class="fa-solid fa-heart"></i> liked 
                        <a class="u-like-of h-cite" href="<?= $post->{'like-of'} ?>"><?= $post->{'like-of'} ?></a>
                    </p>
    
                    <a class="no-underline u-url" href="<?= $post->uri ?>">
                        <time class="dt-published"><?= $post->date ?></time>
                    </a>
                </div>

                <?php include "partials/author.php" ?>
            </article>
        <?php
    
    } else if ($post->type == "bookmark") {

    ?>
        <article class="h-entry">
            <div>
                <div>
                    <p class="p-name">
                        <i class="fa-solid fa-bookmark"></i> 
                        <a class="u-bookmark-of h-cite" href="<?= $post->{'bookmark-of'} ?>"><?= $post->{'bookmark-of'} ?></a>
                    </p>

                    <div class="p-summary e-content">
                        <?= $post->content ?>
                    </div>
                </div>

                <a class="no-underline u-url" href="<?= $post->uri ?>">
                    <time class="dt-published"><?= $post->date ?></time>
                </a>
            </div>

            <?php include "partials/author.php" ?>
        </article>
    <?php

    }
}

// Method to debug the micropub endpoint
// It crashes the endpoint and logs the 
// request to log.json
function debugEndpoint() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
    print_r($_POST);

    $file = fopen('log.json', 'w+');
    fwrite($file, json_encode($_POST));
    fclose($file);

    exit;
}

function sendWebmentions($url) {
    $client = new IndieWeb\MentionClient();
    $sent = $client->sendMentions($url);

    $file = fopen('log.json', 'w+');
    fwrite($file, '{"message": "Sent '.$sent.' mentions.", "url": "'.$url.'"}');
    fclose($file);
}
?>