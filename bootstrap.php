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

if ($new_items = $say_cheese->getNewItems()) {
    foreach ($new_items as $result) {
        $title = $result['titles'];
        $link = $result['link'];

        $bot->sendMessage(getenv('BOT_CHAT_ID'), $bot->getWelcomeMessage($title, $link));
        $cache->addNewItem($title);
    }
}

