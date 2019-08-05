<?php

namespace App\Tests\Resources;

use DOMDocument;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\DomCrawler\Crawler;

trait ImageCrawlTrait
{
    /** @var DOMDocument $document */
    protected DOMDocument $document;

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->document = new DOMDocument();
    }

    /**
     * @param array $imageValues
     * @return MockObject
     */
    protected function generateTargetElement($imageValues = []): MockObject
    {
        $element = $this->createMock(Crawler::class);

        $images = [];

        foreach ($imageValues as $imageValue) {
            $imageElement = $this->document->createElement('img');
            $imageElement->setAttribute('src', $imageValue['src'] ?? 'https://example.com/image.png');
            $imageElement->setAttribute('title', $imageValue['title'] ?? 'Example image');
            $imageElement->setAttribute('alt', $imageValue['alt'] ?? 'Alt text for image');
            $images[] = ($imageElement);
        }

        $element->expects($this->any())
            ->method('filter')
            ->willReturn($images);

        return $element;
    }
}