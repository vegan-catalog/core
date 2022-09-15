<?php

namespace VeganCatalog\Product\Tests;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use VeganCatalog\Product\Domain\Specification;

class SpecificationTest extends TestCase
{
    public function testSetCorrectIds(): void
    {
        $ids = [Uuid::uuid4(),Uuid::uuid4()];
        static::assertEquals(
            $ids,
            (new Specification())->setIds($ids)->ids()
        );
    }

    public function testSetWrongIds(): void
    {
        $wrongIds = [
            [1.2],
            [1,2],
            [null],
            [[]],
            ['string'],
            [true],
            [new \stdClass()],
        ];
        foreach ($wrongIds as $wrongId) {
            try {
                (new Specification())->setIds($wrongId);
                static::fail('Expected exception was not thrown');
            } catch (\Throwable $e) {
                static::assertInstanceOf(InvalidArgumentException::class, $e);
                continue;
            }
        }
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
}
