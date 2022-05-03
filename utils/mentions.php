<?php
// Utils for sending webmentions

function sendWebmentions($url) 
{
    $client = new IndieWeb\MentionClient();
    $sent = $client->sendMentions($url);

    $file = fopen('log.json', 'w+');
    fwrite($file, '{"message": "Sent '.$sent.' mentions.", "url": "'.$url.'"}');
    fclose($file);
}