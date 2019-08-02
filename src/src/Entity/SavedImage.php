<?php

namespace App\Entity;

use App\Model\ScrapedImage;
use Gedmo\Timestampable\Traits\TimestampableEntity;

class SavedImage
{
    use TimestampableEntity;
    use IdTrait;

    /** @var string $filename */
    protected string $filename = '';
    /** @var string $path */
    protected string $path = '';
    /** @var string $pathname */
    protected string $pathname = '';
    /** @var string $baseName */
    protected string $baseName = '';
    /** @var string $publicPath */
    protected string $publicPath = '';
    /** @var ScrapedImage $scrapeOrigin */
    protected ScrapedImage $scrapeOrigin;

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return SavedImage
     */
    public function setFilename(string $filename): SavedImage
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathname(): string
    {
        return $this->pathname;
    }

    /**
     * @param string $pathname
     * @return SavedImage
     */
    public function setPathname(string $pathname): SavedImage
    {
        $this->pathname = $pathname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicPath(): string
    {
        return $this->publicPath;
    }

    /**
     * @param string $path
     * @return SavedImage
     */
    public function setPath(string $path): SavedImage
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return ScrapedImage
     */
    public function getScrapeOrigin(): ?ScrapedImage
    {
        return $this->scrapeOrigin;
    }

    /**
     * @param ScrapedImage $scrapeOrigin
     * @return SavedImage
     */
    public function setScrapeOrigin(ScrapedImage $scrapeOrigin): SavedImage
    {
        $this->scrapeOrigin = $scrapeOrigin;
        return $this;
    }
}