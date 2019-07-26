<?php

namespace App\Service;

use App\Entity\ScrapedImage;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Panther\Client;

class CrawlService
{
    /** @var AdapterInterface $cache */
    protected $cache;
    /** @var Client $client */
    protected $client;
    /** @var int $cacheTTL */
    protected $cacheTTL;

    /**
     * TODO: Inject client
     *
     * CrawlService constructor.
     * @param AdapterInterface $adapter
     * @param int $cacheTimeToLive
     */
    public function __construct(AdapterInterface $adapter, int $cacheTimeToLive)
    {
        $this->cache = $adapter;
        $this->cacheTTL = $cacheTimeToLive;

        $this->client = Client::createChromeClient();
    }

    /**
     * @param string $url
     * @return ScrapedImage[]|array
     * @throws InvalidArgumentException
     */
    public function getImagesFromUrl(string $url): array
    {
        $cacheItem = $this->cache->getItem($this->getCacheKeyOfUrl($url));

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $crawler = $this->client->request('GET', $url);

        $imageNodes = $crawler
            ->filter('img')
            ->getIterator();

        $crawledImages = [];

        foreach ($imageNodes as $imageNode) {
            $crawledImages[] = $this->normalizeImageNode($imageNode);
        }

        $this->cache->save(
            $cacheItem->set($crawledImages)
                ->expiresAfter($this->cacheTTL)
        );

        return $crawledImages;
    }

    /**
     * @param RemoteWebElement $element
     * @return ScrapedImage|null
     */
    protected function normalizeImageNode(RemoteWebElement $element): ?ScrapedImage
    {
        return new ScrapedImage(
            $element->getAttribute('src') ?? '/img/spider.jpg',
            $element->getAttribute('alt') ?? 'None',
            $element->getAttribute('title') ?? 'None'
        );
    }

    /**
     * @param string $item
     * @return string
     */
    protected function getCacheKeyOfUrl(string $item): string
    {
        return md5($item);
    }
}