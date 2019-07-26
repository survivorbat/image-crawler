<?php

namespace App\Entity;

class ScrapedImage
{
    /** @var string $src */
    protected string $src;
    /** @var string $alt */
    protected string $alt;
    /** @var string $title */
    protected string $title;

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
}