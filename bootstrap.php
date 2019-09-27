<?php

use App\Bot;
use App\Register;
use App\SayCheese;
use App\Cache;

require_once 'vendor/autoload.php';
require_once 'constants.php';

(new Register)->registerEnvPackage();

$bot = new Bot;
$cache = new Cache;
$say_cheese = new SayCheese($cache);
$new_items = $say_cheese->getNewItems();

if ($new_items && !empty($new_items)) {
    foreach ($new_items as $result) {
        $title = $result['titles'];
        $link = $result['links'];

        $bot->sendMessage((int) getenv('BOT_CHAT_ID'), $bot->getWelcomeMessage($title, $link));
        $cache->putNewItem($title);
    }
}

