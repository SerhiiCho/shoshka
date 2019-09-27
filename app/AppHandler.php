<?php declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

final class AppHandler
{
    public function registerEnvPackage(): self
    {
        $dot_env = Dotenv::create(APP_DIR);
        $dot_env->load();

        return $this;
    }

    public function sendMessageIfNewReports(): self
    {
        $bot = new Bot;
        $cache = new Cache;
        $say_cheese = new SayCheese($cache);
        $new_items = $say_cheese->getNewItems();

        if (!$new_items || empty($new_items)) {
            exit(1);
        }

        foreach ($new_items as $result) {
            $title = $result['titles'];
            $link = $result['links'];

            $bot->sendMessage((int) getenv('BOT_CHAT_ID'), $bot->getWelcomeMessage($title, $link));
            $cache->putNewItem($title);
        }

        return $this;
    }
}