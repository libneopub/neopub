<?php
// Auto-generated RSS feed

header("Content-Type: text/xml; charset='UTF-8'");
print("<?xml version='1.0' encoding='utf-8' standalone='yes' ?>");

chdir(__DIR__ . "/..");

include "config.php";
include "utils.php";

?>

<rss version="2.0"  xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title><?= $site_title ?></title>
        <description><?= strip_tags($site_description) ?></description>
        <link><?= $site_url ?></link>
        <language><?= strtolower($site_language) ?></language>
        <atom:link href="<?= $site_url . "/content/feed" ?>" rel="self" type="application/rss+xml" />
        
        <?php
            $file = "content/feed.json";

            if(file_exists($file) && filesize($file) > 0){
                $handle = fopen($file, "a+");
                $posts_json = fread($handle, filesize($file));
                $posts = json_decode($posts_json);
                fclose($handle);

                foreach ($posts as $post){
                    $date = date_create_from_format('Y-m-d H:i:s', $post->date);
                    $date = date_format($date, DateTime::RFC822);

                    $content = getRawContent($post)

                    ?>
                        <item>
                            <description>
                                <?= strip_tags($content) ?>
                            </description>
                            <content:encoded>
                                <![CDATA[
                                    <?= $content ?>
                                ]]>
                            </content:encoded>
                            <link><?= $post->uri ?></link>
                            <guid><?= $post->uri ?></guid>
                            <comments><?= $post->uri."#webmentions" ?></comments>
                            <pubDate><?= $date ?></pubDate>
                        </item>
                    <?php
                }
            }
        ?>
    </channel>
</rss>
