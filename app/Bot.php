<?php declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;

class Bot
{
    public function request(string $method, ?array $params = [])
    {
        $token = getenv('BOT_TOKEN');

        $base_uri = "https://api.telegram.org/bot{$token}/{$method}";
        $base_uri .= empty($params) ? '' : '?' . http_build_query($params);

        $client = (new Client(compact('base_uri')))->request('GET');

        return json_decode($client->getBody()->getContents());
    }

    public function sendMessage(int $chat_id, string $text)
    {
        $parse_mode = 'html';
        return $this->request('sendMessage', compact('text', 'chat_id', 'parse_mode'));
    }
}
