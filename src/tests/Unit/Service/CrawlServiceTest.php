<?php

namespace App\Tests\Unit\Service;

use App\Model\ScrapedImage;
use App\Service\CrawlService;
use App\Tests\Resources\ImageCrawlTrait;
use Cache\Adapter\Common\CacheItem;
use DOMDocument;
use Goutte\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * TODO: Add more scenario's
 *
 * @coversDefaultClass \App\Service\CrawlService
 * @covers ::_construct
 */
class CrawlServiceTest extends TestCase
{
    use ImageCrawlTrait;

    /** @var MockObject|AdapterInterface $cacheAdapter */
    protected MockObject $cacheAdapter;
    /** @var MockObject|Client $client */
    protected MockObject $client;
    /** @var MockObject|CacheItem $cacheItem */
    protected MockObject $cacheItem;
    /** @var int $cacheTTL */
    protected int $cacheTTL;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->cacheAdapter = $this->createMock(AdapterInterface::class);
        $this->client = $this->createMock(Client::class);
        $this->cacheItem = $this->createMock(CacheItem::class);
        $this->cacheTTL = 20;
    }

    /**
     * @covers ::getImagesFromUrl
     * @throws InvalidArgumentException
     */
    public function testIfImagesAreRetrievedProperly(): void
    {
        $url = "https://example.com";
        $service = new CrawlService($this->cacheAdapter, $this->client, $this->cacheTTL);
        $domElement = $this->generateTargetElement(
            [
                [
                    'src' => "$url/images/image.png",
                    'title' => '',
                    'alt' => 'Header image'
                ],
                [
                    'src' => "$url/img/test.jpeg",
                    'title' => 'Footer image',
                    'alt' => 'Footer image'
                ]
            ]
        );

        $this->cacheAdapter->expects($this->once())
            ->method('getItem')
            ->with(md5($url))
            ->willReturn($this->cacheItem);

        $this->cacheAdapter->expects($this->once())
            ->method('save');

        $this->cacheItem->expects($this->once())
            ->method('isHit')
            ->willReturn(false);

        $this->cacheItem->expects($this->once())
            ->method('set')
            ->willReturn($this->cacheItem);

        $this->cacheItem->expects($this->once())
            ->method('expiresAfter')
            ->with($this->cacheTTL)
            ->willReturn($this->cacheItem);

        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', $url)
            ->willReturn($domElement);

        $images = $service->getImagesFromUrl(
            $url,
            true
        );

        $this->assertCount(2, $images);

        $image1 = $images[0];

        $this->assertEquals('Header image', $image1->getAlt());
        $this->assertEquals('', $image1->getTitle());
        $this->assertEquals("$url/images/image.png", $image1->getSrc());
        $this->assertEquals($url, $image1->getScrapeUrl());

        $image2 = $images[1];

        $this->assertEquals('Footer image', $image2->getTitle());
        $this->assertEquals('Footer image', $image2->getAlt());
        $this->assertEquals("$url/img/test.jpeg", $image2->getSrc());
        $this->assertEquals($url, $image2->getScrapeUrl());
    }
}