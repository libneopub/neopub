<?php
// Utils to render HTML

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

                <div class="sub">
                    <a class="no-underline u-url" href="<?= $post->uri ?>">
                        <time class="dt-published"><?= $post->date ?></time>
                    </a>
                    <p>
                        <?php
                            foreach ($post->tags as $tag) {
                                ?><a class="p-category" href="/tag/<?= $tag ?>">#<?= $tag ?></a> <?php
                            } 
                        ?>
                    </p>
                </div>
            </div>

            <?php include "partials/author.php" ?>
        </article>
    <?php

    } else if ($post->type == "reply") {

    ?>
        <article class="h-entry">
            <div>
                <div>
                    <p class="title">
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
                <p class="e-content title">
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
                    <p class="e-content title">
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
                    <p class="title">
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
                            foreach ($post->tags as $tag) {
                                ?><a class="p-category" href="/tag/<?= $tag ?>">#<?= $tag ?></a> <?php
                            } 
                        ?>
                    </p>
                </div>
            </div>

            <?php include "partials/author.php" ?>
        </article>
    <?php

    }
}

// Method to render raw content
// without microformats2.
// Used in the RSS feed.
function getRawContent($post) {
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