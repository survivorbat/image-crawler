<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

class ScrapeOrigin
{
    use TimestampableEntity;
    use IdTrait;

    /** @var string $url */
    protected string $url = '';
    /** @var Collection|SavedImage[] $savedImages */
    protected Collection $savedImages;

    /**
     * ScrapeOrigin constructor.
     */
    public function __construct()
    {
        $this->savedImages = new ArrayCollection();
    }

    /**
     * @param string $url
     * @return ScrapeOrigin
     */
    public function setUrl(string $url): ScrapeOrigin
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param SavedImage[]|ArrayCollection $savedImages
     * @return ScrapeOrigin
     */
    public function setSavedImages(ArrayCollection $savedImages)
    {
        $this->savedImages = $savedImages;
        return $this;
    }

    /**
     * @return SavedImage[]|ArrayCollection
     */
    public function getSavedImages(): Collection
    {
        return $this->savedImages;
    }
}
