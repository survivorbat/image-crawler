<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Timestampable\Traits\TimestampableEntity;

class ScrapeOrigin
{
    use TimestampableEntity;
    use IdTrait;

    /** @var string $url */
    protected string $url = '';
    /** @var ArrayCollection|SavedImage[] $savedImages */
    protected $savedImages;

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
     * @param SavedImage[]|ArrayCollection $savedImages
     * @return ScrapeOrigin
     */
    public function setSavedImages(ArrayCollection $savedImages)
    {
        $this->savedImages = $savedImages;
        return $this;
    }
}
