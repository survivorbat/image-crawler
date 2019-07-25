<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ImageService
{
    /** @var Filesystem $fs */
    protected $fs;
    /** @var Finder $finder */
    protected $finder;
    /** @var string $basePath */
    protected $basePath;

    /**
     * ImageService constructor.
     * @param Filesystem $fs
     * @param Finder $finder
     * @param array $settings
     */
    public function __construct(Filesystem $fs, Finder $finder, array $settings)
    {
        $this->fs = $fs;
        $this->finder = $finder;
        $this->basePath = $settings['basePath'] ?? __DIR__ . '/../../public';
    }
}