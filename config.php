<?php
// Main site config 

$site_title = 'Robijntje\'s microblog';
$site_url = 'https://micro.geheimesite.nl';
$site_language = 'en-US';
$site_description = 'I\'m <a href="https://geheimesite.nl">Robin Boers</a>, but my friends call me Robijntje. I\'m a 15-year old frontend designer and Elixir developer from the Netherlands. This is my neolog.';
$site_author = 'Robijntje';
$site_author_profile_picture = '/assets/me.jpeg';
$site_domain = "https://geheimesite.nl"; // used if the neolog isn't your main site
$current_domain = "https://micro.geheimesite.nl"; // used for auth in plugins

// IndieAuth
$token_endpoint = 'https://tokens.indieauth.com/token';
$authorization_endpoint = 'authorization_endpoint';
$github_user = 'RobinBoers';
$twitter_user = '';

// Webmentions
$webmention_endpoint = 'https://webmention.io/geheimesite.nl/webmention';
$pingback = 'https://webmention.io/geheimesite.nl/xmlrpc';

// Micro{sub, pub}
$microsub = 'https://aperture.p3k.io/microsub/733';
