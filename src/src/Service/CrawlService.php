<?php

namespace App\Service;

use Symfony\Component\Panther\Client;

class CrawlService
{
    /**
     * @param string $url
     * @return array
     */
    public function getImagesFromUrl(string $url): array
    {
        $client = Client::createChromeClient();

        $client->request('GET', $url);

        return [];
    }
}