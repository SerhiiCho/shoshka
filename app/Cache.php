<?php declare(strict_types=1);

namespace App;

class Cache
{
    public function getItems(): array
    {
        $items = explode('|', file_get_contents(TITLES_CACHE));

        return array_filter($items, function ($item) {
            return !empty(trim($item));
        });
    }

    public function addNewItem(string $item_title): void
    {
        $text = "{$item_title}|" . file_get_contents(TITLES_CACHE);
        file_put_contents(TITLES_CACHE, $text);
    }
}
