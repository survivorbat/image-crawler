<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSavedImages extends Fixture implements OrderedFixtureInterface
{
    const AMOUNT = 20;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return 2;
    }
}