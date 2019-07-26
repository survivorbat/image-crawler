<?php

namespace App\Entity;

class ScrapeRequest
{
    /** @var string $url */
    protected ?string $url = '';

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return ScrapeRequest
     */
    public function setUrl(?string $url): ScrapeRequest
    {
        $this->url = $url;
        return $this;
    }
}