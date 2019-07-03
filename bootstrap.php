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
        $message = <<<TEXT
        Привет! Я нашла новый фото отчет "{$result['titles']}" на SayCheese.
        Вот посмотри:
        <a href="{$result['links']}">ПЕРЕЙТИ К АЛЬБОМУ</a>
        TEXT;

        $bot->sendMessage(464360946, $message);
        $cache->addNewItem($result['titles']);
    }
}

