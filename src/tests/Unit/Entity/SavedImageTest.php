<?php

namespace App\Tests\Unit\Entity;

use App\Entity\SavedImage;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Entity\SavedImage
 * @covers \App\Entity\SavedImage
 */
class SavedImageTest extends TestCase
{
    use EntityGetSetTestTrait;

    /** @var string $class */
    protected string $class = SavedImage::class;
}