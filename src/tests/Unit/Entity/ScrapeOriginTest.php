<?php

namespace App\Tests\Unit\Entity;

use App\Entity\SavedImage;
use App\Entity\ScrapeOrigin;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Entity\ScrapeOrigin
 * @covers ::_construct
 */
class ScrapeOriginTest extends TestCase
{
    /**
     * @covers ::setUrl
     * @covers ::getUrl
     */
    public function testIfUrlIsSetCorrectly(): void
    {
        $scrapeOrigin = new ScrapeOrigin();
        $scrapeOrigin->setUrl("https://example.com");
        $this->assertEquals("https://example.com", $scrapeOrigin->getUrl());
    }

    /**
     * @covers ::setSavedImages
     * @covers ::getSavedImages
     */
    public function testIfSavedImagesAreSetCorrectly(): void
    {
        $scrapeOrigin = new ScrapeOrigin();
        $scrapeOrigin->setSavedImages(
            new ArrayCollection([new SavedImage(), new SavedImage()])
        );
        $this->assertEquals(
            new ArrayCollection([new SavedImage(), new SavedImage()]),
            $scrapeOrigin->getSavedImages()
        );
    }
}