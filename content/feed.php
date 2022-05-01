<?php

header("Content-Type: text/xml; charset='utf-8'");
print("<?xml version='1.0' encoding='UTF-8' ?>");

include "../config.php";

?>

<rss version="2.0">
    <channel>
        <title><?= $site_title ?></title>
        <description><?= $site_description ?></description>
        <link><?= $_SERVER['SERVER_NAME'].$root_path ?></link>
        <copyright>&copy; <?= date("Y"); ?> <?= $site_author ?> All rights reserved</copyright>
        <language><?= strtolower($site_language) ?></language>
        
        <?php
            $file = "feed.json";

            if(file_exists($file) && filesize($file) > 0){
                $handle = fopen($file, "a+");
                $posts_json = fread($handle, filesize($file));
                $posts = json_decode($posts_json);
                fclose($handle);

                foreach ($posts as $post){
                        ?>
                        <item>
                            <title></title>
                            <description>
                                <?php 
                                    echo preg_replace('/\<(img|br)([^>]*)(?<!\/)>/', '<\1\2/>', $post->content);
                                ?>
                            </description>
                            <link><?= $post->uri ?></link>
                            <comments><?= $post->uri."#comments" ?></comments>
                            <pubDate><?= $post->date ?></pubDate>
                        </item>
                        <?php
                }
            }
        ?>
    </channel>
</rss>
