<?php declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;

class SayCheese
{
    public $old_items;
    public $new_items;
    private $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /** Get html string from saycheese.com.ua */
    public function getHtml(): string
    {
        $client = new Client(['base_uri' => getenv('BOT_TARGET_URL')]);

        return $client->request('GET')->getBody()->getContents();
    }

    /**
     * Parse the page and return array with links
     * and titles.
     */
    public function getLastItems(): array
    {
        $items = [];
        $html = $this->getHtml();

        preg_match_all(LINK_REGEX, $html, $match_links);
        preg_match_all(TITLE_REGEX, $html, $match_titles);

        $items['links'] = $match_links[1];
        $items['titles'] = $match_titles[1];

        return $items;
    }


    /**
     * If if stored items don't have one of those
     * that are came from get request to saycheese.
     */
    public function hasNewItem(): bool
    {
        $this->new_items = $this->getLastItems();
        $this->old_items = $this->cache->getListOfItems();

        return $this->old_items !== $this->new_items['titles'];
    }

    /**
     * Get new parsed item from saycheese.com.ua site.
     */
    public function getNewItems(): ?array
    {
        if ($this->hasNewItem()) {
            $missing_items = [];
            $new_items = $this->new_items['titles'];
            $old_items = $this->old_items;

            sort($new_items);
            sort($old_items);

            for ($i = 0; $i < count($new_items); $i++) {
                if (in_array($this->new_items['titles'][$i], $old_items)) {
                    continue;
                }

                $missing_items[$i]['titles'] = $this->new_items['titles'][$i];
                $missing_items[$i]['links'] = $this->new_items['links'][$i];
            }

            return $missing_items;
        }

        return null;
    }
}
