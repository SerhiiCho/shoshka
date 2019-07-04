<?php declare(strict_types=1);

namespace App;

class Cache
{
    public function getListOfItems(): array
    {
        $this->createFileIfNotExist(TITLES_CACHE);

        $items = explode('|', file_get_contents(TITLES_CACHE));

        return array_filter($items, function ($item) {
            return !empty(trim($item));
        });
    }

    public function putNewItem(string $item_title): void
    {
        $this->createFileIfNotExist(TITLES_CACHE);

        $old_text = file_get_contents(TITLES_CACHE);
        $new_text = "$item_title|$old_text";

        file_put_contents(TITLES_CACHE, $new_text);
    }

    private function createFileIfNotExist(string $file_path): void
    {
        if (!file_exists($file_path)) {
            file_put_contents($file_path, null);
        }
    }
}
