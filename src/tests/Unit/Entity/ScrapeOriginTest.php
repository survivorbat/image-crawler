<?php

namespace App\Tests\Unit\Entity;

use App\Entity\SavedImage;
use App\Entity\ScrapeOrigin;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Entity\ScrapeOrigin
 * @covers \App\Entity\ScrapeOrigin
 */
class ScrapeOriginTest extends TestCase
{
    use EntityGetSetTestTrait;

    /** @var string $class */
    protected string $class = ScrapeOrigin::class;
}