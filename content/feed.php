<?php

header("Content-Type: text/xml; charset='UTF-8'");
print("<?xml version='1.0' encoding='UTF-8' ?>");

include "../config.php";

?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title><?= $site_title ?></title>
        <description><?= $site_description ?></description>
        <link><?= $site_url ?></link>
        <language><?= strtolower($site_language) ?></language>
        <atom:link href="<?= $site_url . "/content/feed" ?>" rel="self" type="application/rss+xml" />
        
        <?php
            $file = "feed.json";

            if(file_exists($file) && filesize($file) > 0){
                $handle = fopen($file, "a+");
                $posts_json = fread($handle, filesize($file));
                $posts = json_decode($posts_json);
                fclose($handle);

                foreach ($posts as $post){
                    $date = date_create_from_format('Y-m-d H:i:s', $post->date);
                    $date = date_format($date, DateTime::RFC822);

                    ?>
                        <item>
                            <description>
                                <?php
                                if ($post->type === "note") {

                                ?>
                                    <div>
                                        <?= $post->content ?>
                                    </div>
                                <?php

                                } else if ($post->type == "reply") {

                                ?>
                                    <p>
                                        💬 replied to 
                                        <a href="<?= $post->{'in-reply-to'} ?>"><?= $post->{'in-reply-to'} ?></a>
                                    </p>
                                    <div>
                                        <?= $post->content ?>
                                    </div>
                                <?php

                                } else if ($post->type == "repost") {

                                ?>
                                    <p>
                                        🔄 reposted 
                                        <a href="<?= $post->{'repost-of'} ?>"><?= $post->{'repost-of'} ?></a>
                                    </p>
                                <?php

                                } else if ($post->type == "like") {

                                    ?>
                                        <p>
                                            ❤️ liked 
                                            <a href="<?= $post->{'like-of'} ?>"><?= $post->{'like-of'} ?></a>
                                        </p>
                                    <?php
                                
                                } else if ($post->type == "bookmark") {

                                ?>
                                    <p>
                                        🔖 <a href="<?= $post->{'bookmark-of'} ?>" class="u-bookmark-of h-cite"><?= $post->name ?></a>
                                    </p>
                                    <div>
                                        <?= $post->content ?>
                                    </div>
                                <?php 
                            
                                } ?>
                            </description>
                            <link><?= $post->uri ?></link>
                            <guid><?= $post->uri ?></guid>
                            <comments><?= $post->uri."#comments" ?></comments>
                            <pubDate><?= $date ?></pubDate>
                        </item>
                    <?php
                }
            }
        ?>
    </channel>
</rss>
