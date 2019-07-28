<?php

namespace App\Service;

use App\Entity\SavedImage;
use App\Entity\ScrapedImage;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Intl\Exception\NotImplementedException;

class SaveService
{
    /** @var Filesystem $fs */
    protected $fs;

    /**
     * SaveService constructor.
     * @param Filesystem $fs
     */
    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
    }

    /**
     * @param ScrapedImage $image
     * @return SavedImage
     */
    public function saveImage(ScrapedImage $image): SavedImage
    {
        throw new NotImplementedException("Saving images has not been implemented yet!");
    }
}