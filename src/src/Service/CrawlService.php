<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Panther\Client;

class CrawlService
{
    /** @var AbstractAdapter $cacheAdapter */
    protected $cacheAdapter;

    /**
     * CrawlService constructor.
     * @param AbstractAdapter $adapter
     */
    public function __construct(AbstractAdapter $adapter)
    {
        $this->cacheAdapter = $adapter;
    }

    /**
     * @param string $url
     * @return array
     */
    public function getImagesFromUrl(string $url): array
    {
        $client = Client::createChromeClient();

        $crawler = $client->request('GET', $url);

        $crawler->filter('img');
    }
}