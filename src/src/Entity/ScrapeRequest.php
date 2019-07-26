<?php

namespace App\Entity;

class ScrapeRequest
{
    /** @var string $url */
    protected ?string $url = 'https://';
    /** @var \DateTime $createdAt */
    protected \DateTime $createdAt;

    /**
     * ScrapeRequest constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

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

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}