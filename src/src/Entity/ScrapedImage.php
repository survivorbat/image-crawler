<?php

namespace App\Entity;

class ScrapedImage
{
    /** @var string $src */
    protected string $src = '';
    /** @var string $alt */
    protected string $alt = '';
    /** @var string $title */
    protected string $title = '';
    /** @var string|null $filePathname */
    protected ?string $filePathname;
    /** @var bool $isSaved */
    protected bool $isSaved = false;

    /**
     * ScrapedImage constructor.
     * @param string $src
     * @param string $alt
     * @param string $title
     */
    public function __construct(string $src, string $alt, string $title)
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getHref(): string
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
    public function getFilePathname(): ?string
    {
        return $this->filePathname;
    }

    /**
     * @param string|null $filePathname
     * @return ScrapedImage
     */
    public function setFilePathname(?string $filePathname): ScrapedImage
    {
        $this->filePathname = $filePathname;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSaved(): bool
    {
        return $this->isSaved;
    }

    /**
     * @param bool $isSaved
     * @return ScrapedImage
     */
    public function setIsSaved(bool $isSaved): ScrapedImage
    {
        $this->isSaved = $isSaved;
        return $this;
    }
}