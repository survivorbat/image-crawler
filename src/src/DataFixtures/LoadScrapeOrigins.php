<?php

namespace App\DataFixtures;

use App\Entity\ScrapeOrigin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class LoadScrapeOrigins extends Fixture implements OrderedFixtureInterface
{
    const AMOUNT = 10;

    /** @var Generator $faker */
    protected Generator $faker;

    /**
     * LoadScrapeOrigins constructor.
     */
    public function __construct()
    {
        $this->faker = Factory::create('nl_NL');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::AMOUNT + 1; $i++) {
            $scrapeOrigin = (new ScrapeOrigin())
                ->setUrl($this->faker->url);

            $manager->persist($scrapeOrigin);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return 1;
    }
}