<?php

namespace App\Service;

use App\Entity\ScrapeOrigin;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class ScrapeOriginService
{
    /** @var EntityManagerInterface $em */
    protected EntityManagerInterface $em;
    /** @var ObjectRepository $scrapeOriginRepository */
    protected ObjectRepository $scrapeOriginRepository;

    /**
     * ScrapeOriginService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->scrapeOriginRepository = $em->getRepository(ScrapeOrigin::class);
    }

    /**
     * @param string $url
     * @return ScrapeOrigin
     */
    public function findOrCreateNew(string $url): ScrapeOrigin
    {
        $scrapeOrigin = $this->scrapeOriginRepository->findOneBy(['url' => $url]);
        return $scrapeOrigin ?? (new ScrapeOrigin())->setUrl($url);
    }
}