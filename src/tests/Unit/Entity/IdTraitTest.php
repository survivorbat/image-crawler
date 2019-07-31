<?php

namespace App\Tests\Unit\Entity;

use App\Entity\IdTrait;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass IdTrait
 * @covers ::__construct
 */
class IdTraitTest extends TestCase
{
    /**
     * @covers ::setId
     * @covers ::getId
     */
    public function testIfClassCanSetId(): void
    {
        $object = new class {
            use IdTrait;
        };

        $object->setId('hello');
        $this->assertEquals('hello', $object->getId());
    }
}