<?php

header('Content-type: application/feed+json; charset=utf-8');

echo json_encode([
    'version' => 'https://jsonfeed.org/version/1.1',
    'title' => $site->title()->value(),
    'home_page_url' => $site->url(),
    'feed_url' => $site->url() . '/feed',
    'items' => $items,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
