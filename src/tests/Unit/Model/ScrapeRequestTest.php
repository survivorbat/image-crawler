<?php

namespace App\Tests\Unit\Model;

use App\Model\ScrapeRequest;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Model\ScrapeRequest
 * @covers ::__construct
 */
class ScrapeRequestTest extends TestCase
{
    /**
     * @covers ::getUrl
     * @covers ::setUrl
     */
    public function testIfUrlCanBeSet(): void
    {
        $scrapeRequest = new ScrapeRequest();
        $scrapeRequest->setUrl("https://example.com");

        $this->assertEquals("https://example.com", $scrapeRequest->getUrl());
    }
}