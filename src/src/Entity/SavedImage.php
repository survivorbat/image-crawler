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
    /** @var string $pathname */
    protected string $pathname = '';
    /** @var string $baseName */
    protected string $baseName = '';
    /** @var string $publicPath */
    protected string $publicPath = '';
    /** @var string $realPath */
    protected string $realPath = '';
    /** @var string $extension */
    protected string $extension = '';
    /** @var string $path */
    protected string $path = '';
    /** @var ScrapedImage $scrapeOrigin */
    protected string $scrapeOrigin = '';
    /** @var resource|null $file */
    protected $file;

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
    public function getBaseName(): string
    {
        return $this->baseName;
    }

    /**
     * @param string $baseName
     * @return SavedImage
     */
    public function setBaseName(string $baseName): SavedImage
    {
        $this->baseName = $baseName;
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
     * @param string $publicPath
     * @return SavedImage
     */
    public function setPublicPath(string $publicPath): SavedImage
    {
        $this->publicPath = $publicPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getRealPath(): string
    {
        return $this->realPath;
    }

    /**
     * @param string $realPath
     * @return SavedImage
     */
    public function setRealPath(string $realPath): SavedImage
    {
        $this->realPath = $realPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return SavedImage
     */
    public function setExtension(string $extension): SavedImage
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
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
     * @return resource|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param resource|null $file
     * @return SavedImage
     */
    public function setFile($file): SavedImage
    {
        $this->file = $file;
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