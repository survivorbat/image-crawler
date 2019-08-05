<?php

namespace App\Tests\Integration\Service;

use App\Service\CrawlService;
use App\Tests\Resources\ImageCrawlTrait;
use Doctrine\Common\Cache\ArrayCache;
use Goutte\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * @coversDefaultClass \App\Service\CrawlService
 * @covers ::__construct
 */
class CrawlServiceTest extends TestCase
{
    use ImageCrawlTrait;

    /** @var MockObject|Client $client */
    protected MockObject $client;
    /** @var AdapterInterface $cache */
    protected AdapterInterface $cache;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->cache = new FilesystemAdapter();
        $this->cache->clear();
    }

    /**
     * @covers ::getImagesFromUrl
     * @throws InvalidArgumentException
     */
    public function testGetNormalImages(): void
    {
        $url = 'https://example.com';
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
                ],
                [
                    'src' => "$url/img/test.jpeg",
                    'title' => 'Footer image',
                    'alt' => 'Footer image'
                ]
            ]
        );

        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', $url)
            ->willReturn($domElement);

        $service = new CrawlService(
            $this->cache,
            $this->client,
            3000
        );

        $images = $service->getImagesFromUrl($url);

        $this->assertCount(3, $images);
    }

    /**
     * @covers ::getImagesFromUrl
     * @throws InvalidArgumentException
     */
    public function testIfResultGetsCached(): void
    {
        $url = 'https://example.com';
        $domElement = $this->generateTargetElement(
            [
                [
                    'src' => "$url/images/image.png",
                    'title' => '',
                    'alt' => 'Header image'
                ]
            ]
        );
        $domElementNext = $this->generateTargetElement(
            [
                [
                    'src' => "$url/images/image.png",
                    'title' => '',
                    'alt' => ''
                ],
                [
                    'src' => "$url/favicon.jpeg",
                    'title' => '',
                    'alt' => ''
                ],
            ]
        );

        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', $url)
            ->willReturn($domElement);

        $service = new CrawlService(
            $this->cache,
            $this->client,
            3000
        );

        $images = $service->getImagesFromUrl($url, false);
        $this->assertCount(1, $images);

        $images = $service->getImagesFromUrl($url, false);
        $this->assertCount(1, $images);
    }

    /**
     * @covers ::getImagesFromUrl
     * @throws InvalidArgumentException
     */
    public function testIfResultDoesNotGetCachedWithParameter(): void
    {
        $url = 'https://example.com';
        $domElement = $this->generateTargetElement(
            [
                [
                    'src' => "$url/images/image.png",
                    'title' => '',
                    'alt' => 'Header image'
                ]
            ]
        );
        $domElementNext = $this->generateTargetElement(
            [
                [
                    'src' => "$url/images/image.png",
                    'title' => '',
                    'alt' => ''
                ],
                [
                    'src' => "$url/favicon.jpeg",
                    'title' => '',
                    'alt' => ''
                ],
            ]
        );

        $calledTimes = 0;
        $this->client->expects($this->exactly(2))
            ->method('request')
            ->with('GET', $url, [], [], [], null, true)
            ->willReturnCallback(function () use (&$calledTimes, $domElement, $domElementNext) {
                switch (++$calledTimes) {
                    case 1:
                        return $domElement;
                    case 2:
                        return $domElementNext;
                    default:
                        throw new \BadMethodCallException('This request method should not have been called!');
                }
            });

        $service = new CrawlService(
            $this->cache,
            $this->client,
            3000
        );

        $images = $service->getImagesFromUrl($url, true );
        $this->assertCount(1, $images);

        $images = $service->getImagesFromUrl($url, true);
        $this->assertCount(2, $images);
    }
}