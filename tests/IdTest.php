<?php

namespace VeganCatalog\Core\Tests;

use PHPUnit\Framework\TestCase;
use VeganCatalog\Core\Id;

class IdTest extends TestCase
{
    public function testFromString(): void
    {
        $id = Id::another();
        static::assertEquals(
            $id,
            Id::fromString($id->toString())
        );
    }
}
