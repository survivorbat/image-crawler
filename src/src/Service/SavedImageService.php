<?php

namespace App\Service;

use App\Entity\SavedImage;
use App\Model\ScrapedImage;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

class SavedImageService
{
    /** @var ScrapeOriginService $originService */
    protected ScrapeOriginService $originService;
    /** @var Filesystem $fs */
    protected Filesystem $fs;
    /** @var EntityManagerInterface $em */
    protected EntityManagerInterface $em;
    /** @var ObjectRepository $repository */
    protected ObjectRepository $repository;
    /** @var string $saveDir */
    protected string $saveDir;
    /** @var string $publicDir */
    protected string $publicDir;

    /**
     * SaveService constructor.
     * @param ScrapeOriginService $originService
     * @param Filesystem $fs
     * @param EntityManagerInterface $em
     * @param string $saveDir
     * @param string $publicDir
     */
    public function __construct(
        ScrapeOriginService $originService,
        Filesystem $fs,
        EntityManagerInterface $em,
        string $saveDir,
        string $publicDir
    ) {
        $this->originService = $originService;
        $this->fs = $fs;
        $this->em = $em;
        $this->repository = $em->getRepository(SavedImage::class);
        $this->saveDir = $saveDir;
        $this->publicDir = $publicDir;
    }

    /**
     * @return SavedImage[]|array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param ScrapedImage[]|array $images
     * @return void
     */
    public function saveImages(array $images): void
    {
        foreach ($images as $image) {
            $subDir = md5($image->getScrapeUrl());
            $path = $this->saveDir . DIRECTORY_SEPARATOR . $subDir;
            $this->fs->mkdir($path);
            $fileName = md5($image->getSrc()) . '.png';
            $filePathname = $path . DIRECTORY_SEPARATOR . $fileName;
            $publicPath = $this->publicDir . DIRECTORY_SEPARATOR . $subDir . DIRECTORY_SEPARATOR . $fileName;

            $savedImage = (new SavedImage())
                ->setFilename($fileName)
                ->setPath($path)
                ->setPathname($filePathname)
                ->setPublicPath($publicPath)
                ->setScrapeOrigin($this->originService->findOrCreateNew($image->getScrapeUrl()));

            try {
                $imageContents = file_get_contents($image->getSrc());
                $imageFile = imagecreatefromstring($imageContents);
            }
            catch (\Exception $exception) {
                continue;
                // TODO: Handle this exception, display a small error or something of that sense
            }

            imagesavealpha($imageFile, true);
            imagealphablending($imageFile, false);
            imagepng($imageFile, $filePathname);

            $this->em->persist($savedImage);
        }

        $this->em->flush();
    }
}