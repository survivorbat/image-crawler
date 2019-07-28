<?php

namespace App\Service;

use App\Entity\SavedImage;
use App\Model\ScrapedImage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Intl\Exception\NotImplementedException;

class SavedImageService
{
    /** @var Filesystem $fs */
    protected $fs;
    /** @var EntityManagerInterface $em */
    protected $em;
    /** @var EntityRepository $repository */
    protected $repository;
    /** @var string $saveDir */
    protected $saveDir;

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
     * @param array $images
     * @return void
     */
    public function saveImages(array $images): void
    {
        foreach ($images as $image) {
            $savedImage = (new SavedImage());

            $this->em->persist($image);
        }

        $this->em->flush();
    }
}