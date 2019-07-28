<?php

namespace App\Model;

class ScrapedImage
{
    /** @var string $src */
    protected string $src;
    /** @var string $alt */
    protected string $alt;
    /** @var string $title */
    protected string $title;
    /** @var string $scrapeUrl */
    protected string $scrapeUrl;

    /**
     * ScrapedImage constructor.
     * @param string $src
     * @param string $alt
     * @param string $title
     * @param string $scrapeUrl
     */
    public function __construct(string $src, string $alt, string $title, string $scrapeUrl)
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->title = $title;
        $this->scrapeUrl = $scrapeUrl;
    }

    /**
     * @return string
     */
    public function getSrc(): string
    {
        return $this->src;
    }

    /**
     * @return string
     */
    public function getAlt(): string
    {
        return $this->alt;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getScrapeUrl(): string
    {
        return $this->scrapeUrl;
    }

    /**
     * @param string $scrapeUrl
     * @return ScrapedImage
     */
    public function setScrapeUrl(string $scrapeUrl): ScrapedImage
    {
        $this->scrapeUrl = $scrapeUrl;
        return $this;
    }
}