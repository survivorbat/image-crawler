<?php

namespace App\Service;

use App\Model\ScrapedImage;
use Goutte\Client;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class CrawlService
{
    /** @var AdapterInterface $cache */
    protected AdapterInterface $cache;
    /** @var Client $client */
    protected Client $client;
    /** @var int $cacheTTL */
    protected int $cacheTTL;

    /**
     * CrawlService constructor.
     * @param AdapterInterface $adapter
     * @param Client $client
     * @param int $cacheTimeToLive
     */
    public function __construct(AdapterInterface $adapter, Client $client, int $cacheTimeToLive)
    {
        $this->cache = $adapter;
        $this->cacheTTL = $cacheTimeToLive;
        $this->client = $client;
    }

    /**
     * @param string $url
     * @param bool $ignoreCache
     * @return ScrapedImage[]|array
     * @throws InvalidArgumentException
     */
    public function getImagesFromUrl(string $url, bool $ignoreCache = false): array
    {
        $cacheItem = $this->cache->getItem($this->getCacheKeyOfUrl($url));

        if ($cacheItem->isHit() && !$ignoreCache) {
            return $cacheItem->get();
        }

        $imageNodes = $this->client->request('GET', $url)
            ->filter('img');

        $crawledImages = [];

        foreach ($imageNodes as $imageNode) {
            $crawledImages[] = $this->normalizeImageNode($imageNode, $url);
        }

        $this->cache->save(
            $cacheItem->set($crawledImages)->expiresAfter($this->cacheTTL)
        );

        return $crawledImages;
    }

    /**
     * @param \DOMElement $element
     * @param string $baseUrl
     * @return ScrapedImage|null
     */
    protected function normalizeImageNode(\DOMElement $element, string $baseUrl): ScrapedImage
    {
        $src = $element->getAttribute('src');

        if (!$this->containsBaseUrl($src)) {
            $src = "$baseUrl$src";
        }

        return new ScrapedImage(
            $src,
            $element->getAttribute('alt') ?? 'None',
            $element->getAttribute('title') ?? 'None',
            $baseUrl
        );
    }

    /**
     * @param string $url
     * @return bool
     */
    protected function containsBaseUrl(string $url): bool
    {
        return preg_match("/^(https|http):\/\/.*/", $url);
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