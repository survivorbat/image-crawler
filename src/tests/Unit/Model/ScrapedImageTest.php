<?php

namespace App\Tests\Unit\Model;

use App\Model\ScrapedImage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Model\ScrapedImage
 */
class ScrapedImageTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getSrc
     * @covers ::getScrapeUrl
     * @covers ::getAlt
     * @covers ::getTitle
     */
    public function testIfScrapedImageInitializesProperly(): void
    {
        $scrapeUrl = "https://example.com";
        $src = "https://example.com/image.png";
        $alt = "Alternate image text";
        $title = "This is an example image";

        $scrapedImage = new ScrapedImage($src, $alt, $title, $scrapeUrl);

        $this->assertEquals($scrapeUrl, $scrapedImage->getScrapeUrl());
        $this->assertEquals($src, $scrapedImage->getSrc());
        $this->assertEquals($alt, $scrapedImage->getAlt());
        $this->assertEquals($title, $scrapedImage->getTitle());
    }

    /**
     * @covers ::__construct
     * @covers ::getScrapeUrl
     * @covers ::setScrapeUrl
     */
    public function testIfScrapeUrlCanBeSet(): void
    {
        $scrapeUrl = "https://example.com";
        $src = "https://example.com/image.png";
        $alt = "Alternate image text";
        $title = "This is an example image";

        $scrapedImage = new ScrapedImage($src, $alt, $title, $scrapeUrl);
        $scrapedImage->setScrapeUrl("http://test.com");

        $this->assertEquals("http://test.com", $scrapedImage->getScrapeUrl());
    }
}