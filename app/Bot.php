<?php declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;

class Bot
{
    public function request(string $method, ?array $params = [])
    {
        $base_uri = $this->generateRequestUrl($params, $method);

        $client = (new Client(compact('base_uri')))->request('GET');

        return json_decode($client->getBody()->getContents());
    }

    private function generateRequestUrl(?array $params, string $method): string
    {
        $token = getenv('BOT_TOKEN');

        $base_uri = "https://api.telegram.org/bot{$token}/{$method}";
        $base_uri .= empty($params) ? '' : '?' . http_build_query($params);

        return $base_uri;
    }

    public function sendMessage(int $chat_id, string $text)
    {
        $parse_mode = 'html';
        return $this->request('sendMessage', compact('text', 'chat_id', 'parse_mode'));
    }

    public function getWelcomeMessage(string $title, string $link): string
    {
        return <<<TEXT
        Привет! Я нашла новый фото отчет "{$title}" на SayCheese.
        <a href="{$link}">ПЕРЕЙТИ К АЛЬБОМУ</a>
        TEXT;
    }
}
