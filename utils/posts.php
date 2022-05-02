<?php
// Utils for getting and creating posts

require "vendor/autoload.php";
use Michelf\Markdown;

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
// and render them.
function listPosts() {
    $posts_json = file_get_contents("content/feed.json");
    $posts = json_decode($posts_json);

    foreach ($posts as $post) {
        showPost($post);
    }
}

// Method to loop trough all posts
// of a post-type and render them.
function listPostsOfType($type = "note") {
    $posts_json = file_get_contents("content/feed.json");
    $posts = json_decode($posts_json);

    foreach ($posts as $post) {
        if($post->type === $type) {
            showPost($post);
        }
    }
}

// Method to loop trough all posts
// of a post-type and render them.
function listPostsWithTag($tag) {
    $posts_json = file_get_contents("content/feed.json");
    $posts = json_decode($posts_json);

    foreach ($posts as $post) {
        if(in_array($tag, $post->tags)) {
            showPost($post);
        }
    }
}