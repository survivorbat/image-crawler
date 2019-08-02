<?php

namespace App\Service;

use App\Entity\SavedImage;
use App\Model\ScrapedImage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Filesystem\Filesystem;

class SavedImageService
{
    /** @var Filesystem $fs */
    protected $fs;
    /** @var EntityManagerInterface $em */
    protected $em;
    /** @var EntityRepository $repository */
    protected $repository;
    /** @var string $saveDir */
    protected string $saveDir;

    /**
     * SaveService constructor.
     * @param Filesystem $fs
     * @param EntityManagerInterface $em
     * @param string $saveDir
     */
    public function __construct(Filesystem $fs, EntityManagerInterface $em, string $saveDir)
    {
        $this->fs = $fs;
        $this->em = $em;
        $this->repository = $em->getRepository(SavedImage::class);
        $this->saveDir = $saveDir;
    }

    /**
     * @return SavedImage[]|array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * TODO: Add public path and scrape origin
     *
     * @param ScrapedImage[]|array $images
     * @return void
     */
    public function saveImages(array $images): void
    {
        foreach ($images as $image) {
            $path = $this->saveDir . DIRECTORY_SEPARATOR . md5($image->getScrapeUrl());
            $this->fs->mkdir($path);
            $fileName = md5($image->getSrc()) . '.png';
            $fileName = $path . DIRECTORY_SEPARATOR . $fileName;

            $savedImage = (new SavedImage())
                ->setFilename($fileName)
                ->setPath($path)
                ->setPathname($fileName);

            $imageContents = file_get_contents($image->getSrc());
            $imageFile = imagecreatefromstring($imageContents);
            imagepng($imageFile, $fileName);

            $this->em->persist($savedImage);
        }

        $this->em->flush();
    }
}