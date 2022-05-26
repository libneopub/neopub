<?php
// Utils to render HTML

// Method to render a single post
function showPost($post)
{
    if ($post->type === "note") {

    ?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>

            <div>
                <div class="e-content p-summary p-name">
                    <?= $post->content ?>
                </div>

                <div class="sub">
                    <a class="no-underline u-url" href="<?= $post->uri ?>">
                        <time class="dt-published"><?= $post->date ?></time>
                    </a>
                    <p>
                        <?php
                            if(isset($post->tags)) {
                                foreach ($post->tags as $tag) {
                                    ?><a class="p-category" href="/tag/<?= $tag ?>">#<?= $tag ?></a> <?php
                                } 
                            }
                        ?>
                    </p>
                </div>
            </div>
        </article>
    <?php

    } else if ($post->type == "reply") {

    ?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>

            <div>
                <div>
                    <p class="title p-name">
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
        </article>
    <?php

    } else if ($post->type == "repost") {

    ?>
        <article class="h-entry">
            <?php include "partials/author.php" ?>


            <div>
                <p class="e-content title p-name">
                    <i class="fa-solid fa-arrows-spin"></i> reposted 
                    <a class="u-repost-of h-cite" href="<?= $post->{'repost-of'} ?>"><?= $post->{'repost-of'} ?></a>
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
                    <p class="e-content title p-name">
                        <i class="fa-solid fa-heart"></i> liked 
                        <a class="u-like-of h-cite" href="<?= $post->{'like-of'} ?>"><?= $post->{'like-of'} ?></a>
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
                <div>
                    <p class="title p-name">
                        <i class="fa-solid fa-bookmark"></i> 
                        <a class="u-bookmark-of h-cite" href="<?= $post->{'bookmark-of'} ?>"><?= $post->name ?></a>
                    </p>

                    <div class="p-summary e-content">
                        <?= $post->content ?>
                    </div>
                </div>

                <div class="sub">
                    <a class="no-underline u-url" href="<?= $post->uri ?>">
                        <time class="dt-published"><?= $post->date ?></time>
                    </a>
                    <p>
                        <?php
                            if(isset($post->tags)) {
                                foreach ($post->tags as $tag) {
                                    ?><a class="p-category" href="/tag/<?= $tag ?>">#<?= $tag ?></a> <?php
                                } 
                            }
                        ?>
                    </p>
                </div>
            </div>
        </article>
    <?php

    }
}

// Method to render raw content
// without microformats2.
// Used in the RSS feed.
function getRawContent($post) 
{
    if ($post->type === "note") {

        $content = $post->content;

    } else if ($post->type == "reply") {

        $content = "
            <p>
                💬 replied to 
                <a href='".$post->{'in-reply-to'}."'>".$post->{'in-reply-to'}."</a>:
            </p>
            $post->content
        ";

    } else if ($post->type == "repost") {

        $content = "
            <p>
                🔄 reposted
                <a href='".$post->{'repost-of'}."'>".$post->{'repost-of'}."</a>
            </p>
        ";

    } else if ($post->type == "like") {

        $content = "
            <p>
                ❤️ liked 
                <a href='".$post->{'like-of'}."'>".$post->{'like-of'}."</a>
            </p>
        ";
    
    } else if ($post->type == "bookmark") {

        $content = "
            <p>
                🔖
                <a href='".$post->{'bookmark-of'}."'>$post->name</a>.
            </p>
            $post->content
        ";

    }

    return $content;
}

function showWarning($msg) {
    ?>
        <div class="warning">
            <?= $msg ?> <a href="/">Return to timeline</a>
        </div>
    <?php
}

function showError($msg) {
    ?>
        <div class="error">
            <?= $msg ?> <a href="/">Return to timeline</a>
        </div>
    <?php
}

function showMessage($msg) {
    ?>
        <div class="msg">
            <?= $msg ?>
        </div>
    <?php
}