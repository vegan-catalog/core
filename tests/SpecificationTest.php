<?php

namespace VeganCatalog\Core\Tests;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use VeganCatalog\Core\Id;
use VeganCatalog\Core\IdCollection;
use VeganCatalog\Core\Specification;

class SpecificationTest extends TestCase
{
    public function testSetCorrectIds(): void
    {
        $ids = new IdCollection([
            Id::another()
        ]);
        static::assertEquals(
            $ids,
            (new Specification())->setIds($ids)->ids()
        );
    }

    public function testSetCorrectIsVegan(): void
    {
        $specification = new Specification();
        static::assertTrue($specification->setIsVegan(true)->isVegan());
        static::assertFalse($specification->setIsVegan(false)->isVegan());
    }

    public function testSetTitle(): void
    {
        $title = 'title';
        $specification = new Specification();
        static::assertEquals(
            $title,
            $specification->setTitle($title)->title()
        );
        $this->expectException(InvalidArgumentException::class);
        $specification->setTitle('');
    }

    public function testSetDescription(): void
    {
        $description = 'description';
        $specification = new Specification();
        static::assertEquals(
            $description,
            $specification->setDescription($description)->description()
        );
        $this->expectException(InvalidArgumentException::class);
        $specification->setDescription('');
    }

    public function testSetCreatedAtMin(): void
    {
        $specification = new Specification();
        $createdAtMin = new DateTimeImmutable();
        $specification->setCreatedAtMax($createdAtMin->modify('+1 day'));
        $specification->setCreatedAtMin($createdAtMin);
        static::assertEquals(
            $createdAtMin,
            $specification->createdAtMin()
        );
    }

    public function testSetWrongCreatedAtMin(): void
    {
        $specification = new Specification();
        $createdAtMin = new DateTimeImmutable();
        $specification->setCreatedAtMax($createdAtMin);
        $this->expectException(InvalidArgumentException::class);
        $specification->setCreatedAtMin($createdAtMin);
    }

    public function testSetCreatedAtMax(): void
    {
        $specification = new Specification();
        $createdAtMax = new DateTimeImmutable();
        $specification->setCreatedAtMin($createdAtMax->modify('-1 day'));
        $specification->setCreatedAtMax($createdAtMax);
        static::assertEquals(
            $createdAtMax,
            $specification->createdAtMax()
        );
    }

    public function testSetWrongCreatedAtMax(): void
    {
        $specification = new Specification();
        $createdAtMax = new DateTimeImmutable();
        $specification->setCreatedAtMin($createdAtMax);
        $this->expectException(InvalidArgumentException::class);
        $specification->setCreatedAtMax($createdAtMax);
    }

    public function testSetUpdatedAtMin(): void
    {
        $specification = new Specification();
        $updatedAtMin = new DateTimeImmutable();
        $specification->setUpdatedAtMax($updatedAtMin->modify('+1 day'));
        $specification->setUpdatedAtMin($updatedAtMin);
        static::assertEquals(
            $updatedAtMin,
            $specification->updatedAtMin()
        );
    }

    public function testSetWrongUpdatedAtMin(): void
    {
        $specification = new Specification();
        $updatedAtMin = new DateTimeImmutable();
        $specification->setUpdatedAtMax($updatedAtMin);
        $this->expectException(InvalidArgumentException::class);
        $specification->setUpdatedAtMin($updatedAtMin);
    }

    public function testSetUpdatedAtMax(): void
    {
        $specification = new Specification();
        $updatedAtMax = new DateTimeImmutable();
        $specification->setUpdatedAtMin($updatedAtMax->modify('-1 day'));
        $specification->setUpdatedAtMax($updatedAtMax);
        static::assertEquals(
            $updatedAtMax,
            $specification->updatedAtMax()
        );
    }

    public function testSetWrongUpdatedAtMax(): void
    {
        $specification = new Specification();
        $updatedAtMax = new DateTimeImmutable();
        $specification->setUpdatedAtMin($updatedAtMax);
        $this->expectException(InvalidArgumentException::class);
        $specification->setUpdatedAtMax($updatedAtMax);
    }
}
