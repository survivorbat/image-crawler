<?php

namespace App\Service;

use App\Entity\SavedImage;
use App\Entity\ScrapeOrigin;
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
     * @param ScrapedImage $image
     * @return void
     */
    public function saveImage(ScrapedImage $image): void
    {
        $subDir = md5($image->getScrapeUrl());
        $path = $this->saveDir . DIRECTORY_SEPARATOR . $subDir;
        $this->fs->mkdir($path);

        $fileName = md5($image->getSrc()) . '.png';
        $pathname = $path . DIRECTORY_SEPARATOR . $fileName;
        $publicPath = $this->publicDir . DIRECTORY_SEPARATOR . $subDir . DIRECTORY_SEPARATOR . $fileName;

        $scrapeOrigin = $this->originService->findByUrlIfExists($image->getScrapeUrl())
            ?? (new ScrapeOrigin())->setUrl($image->getScrapeUrl());

        $savedImage = (new SavedImage())
            ->setFilename($fileName)
            ->setPath($path)
            ->setPathname($pathname)
            ->setPublicPath($publicPath)
            ->setScrapeOrigin($scrapeOrigin);

        try {
            $this->fetchAndSaveImage($image, $pathname);
        }
        catch (\ErrorException $exception) {
            // TODO: Handle this
            return;
        }

        $this->em->persist($savedImage);
        $this->em->flush();
    }

    /**
     * @param ScrapedImage $scrapedImage
     * @param string $filePathname
     */
    protected function fetchAndSaveImage(ScrapedImage $scrapedImage, string $filePathname): void
    {
        $imageContents = file_get_contents($scrapedImage->getSrc());
        $imageFile = imagecreatefromstring($imageContents);

        imagesavealpha($imageFile, true);
        imagealphablending($imageFile, false);

        imagepng($imageFile, $filePathname);
    }
}