<?php

namespace App\Tests\Unit\Entity;

use App\Entity\IdTrait;

/**
 * TODO: Finish this
 *
 * @coversDefaultClass
 */
class IdTraitTest extends TestCase
{
    /** @var $idTraitClass */
    protected $idTraitClass;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        $this->idTraitClass = new class {
            use IdTrait;
        };
    }

    public function testIfClassCanSetId(): void
    {

    }
}