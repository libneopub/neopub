<?php
// Utils for getting and creating posts

require __DIR__."/../vendor/autoload.php";
use Michelf\Markdown;

// Method to generate a new 
// note. Returns the note.
function newNote($content, $categories)
{
    global $site_url;
    global $site_author;
    global $currentYear;

    $id = uniqid();
    $url =  "$site_url/post/$currentYear/$id";
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
// photo post. Returns the post.
function newPhoto($file_url, $content, $categories)
{
    global $site_url;
    global $site_author;
    global $currentYear;

    $id = uniqid();
    $url =  "$site_url/post/$currentYear/$id";
    $author = array("name" => $site_author);

    $categories[] = "photo";

    $content = Markdown::defaultTransform($content);
    $photo = "<img src='$file_url' class='u-photo' />";

    $content = $content . $photo;

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
    global $currentYear;

    $id = uniqid();
    $url =  "$site_url/post/$currentYear/$id";
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
    global $currentYear;

    $id = uniqid();
    $url =  "$site_url/post/$currentYear/$id";

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
    global $currentYear;

    $id = uniqid();
    $url =  "$site_url/post/$currentYear/$id";

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
    global $currentYear;

    $id = uniqid();
    $url =  "$site_url/post/$currentYear/$id";

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
// to the <year>.json file (or database)
// Returns the URI of the published post.
function publishPost($post)
{
    global $currentYear;

    if (file_exists(getFeedURL($currentYear))) {
        writePost($currentYear, $post);
    } else {
        createFeedForCurrentYear();
        writePost($currentYear, $post);
    }

    return $post["uri"];
}

function writePost($year, $post) 
{
    $posts_json = file_get_contents(getFeedURL($year));
    $posts = json_decode($posts_json);

    array_unshift($posts, $post);

    $file = fopen(getFeedURL($year), 'w+');
    fwrite($file, json_encode($posts));
    fclose($file);
}

function createFeedForCurrentYear() 
{
    global $currentYear;

    $file = fopen(getFeedURL($currentYear), "w");
    fwrite($file, "[]");
    fclose($file);
}

// Method to get post by its ID
function getPost($year, $id)
{
    $posts_json = file_get_contents(getFeedURL($year));
    $posts = json_decode($posts_json);

    foreach ($posts as $post) {
        if ($post->id === $id) {
            return $post;
        }
    }
}

// Method to loop trough all posts
// and render them.
function listPosts($year) 
{
    if(file_exists(getFeedURL($year))) {
        $posts_json = file_get_contents(getFeedURL($year));
        $posts = json_decode($posts_json);
    } else {
        $posts = [];
    }

    $nothingHere = true;

    foreach ($posts as $post) {
        $nothingHere = false;
        showPost($post);
    }

    if($nothingHere) {
        showMessage("Nothing here. (anymore?)");
    }
}

// Method to loop trough all posts
// of a post-type and render them.
function listPostsOfType($year, $type = "note") 
{
    $posts_json = file_get_contents(getFeedURL($year));
    $posts = json_decode($posts_json);

    $nothingHere = true;

    foreach ($posts as $post) {
        if($post->type === $type) {
            $nothingHere = false;
            showPost($post);
        }
    }

    if($nothingHere) {
        showMessage("Nothing here. (anymore?)");
    }
}

// Method to loop trough all posts
// of a post-type and render them.
function listPostsWithTag($year, $tag) 
{
    $posts_json = file_get_contents(getFeedURL($year));
    $posts = json_decode($posts_json);

    $nothingHere = true;

    foreach ($posts as $post) {
        if(in_array($tag, $post->tags)) {
            $nothingHere = false;
            showPost($post);
        }
    }

    if($nothingHere) {
        showMessage("Nothing here. (anymore?)");
    }
}

// Get absolute URL to feed file for
// specific year
function getFeedURL($year) {
    return __DIR__."/../content/$year.json";
}