<?php
// Partial for the head section of pages

require "config.php";
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="stylesheet" type="text/css" href="/assets/main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/favicon-16x16.png">
<link rel="manifest" href="/assets/icons/site.webmanifest">
<link rel="mask-icon" href="/assets/icons/safari-pinned-tab.svg" color="#ff6666">
<link rel="shortcut icon" href="/assets/icons/favicon.ico">
<meta name="msapplication-TileColor" content="#ff6666">
<meta name="msapplication-config" content="/assets/icons/browserconfig.xml">
<meta name="theme-color" content="#ff6666">

<link rel="alternate" type="application/rss+xml" title="<?= $site_title ?>" href="<?= "$site_url/feed" ?>" />
    
<!-- Micro{sub, pub} -->
<link rel="microsub" href="<?= $microsub ?>">
<link rel="micropub" href="/endpoint.php" />   

<!-- IndieAuth -->
<link rel="authorization_endpoint" href="<?= $authorization_endpoint ?>">
<link rel="token_endpoint" href="<?= $token_endpoint ?>">
<link rel="me" href="https://github.com/<?= $github_user ?>" />

<!-- Webmention -->
<link rel="webmention" href="<?= $webmention_endpoint ?>" />
<link rel="pingback" href="<?= $pingback ?>" />