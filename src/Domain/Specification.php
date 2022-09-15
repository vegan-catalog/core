<?php

declare(strict_types=1);

namespace VeganCatalog\Product\Domain;

use DateTimeInterface;
use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;

final class Specification
{
    private const DATETIME_FORMAT = DateTimeInterface::ATOM;

    private ?array $ids = null;
    private ?bool $isVegan = null;
    private ?DateTimeInterface $createdAtMin = null;
    private ?DateTimeInterface $createdAtMax = null;

    public function ids(): ?array
    {
        return $this->ids;
    }

    public function isVegan(): ?bool
    {
        return $this->isVegan;
    }

    public function createdAtMin(): ?DateTimeInterface
    {
        return $this->createdAtMin;
    }

    public function createdAtMax(): ?DateTimeInterface
    {
        return $this->createdAtMax;
    }

    public function setQuery(string $query): self
    {
        if ($query === '') {
            throw new InvalidArgumentException('Query can\'t be empty');
        }
        $this->query = $query;

        return $this;
    }

    public function setIds(array $ids): self
    {
        foreach ($ids as $id) {
            if (!$id instanceof UuidInterface) {
                throw new InvalidArgumentException('Id must be instance of ' . UuidInterface::class);
            }
        }

        $this->ids = $ids;

        return $this;
    }

    public function setIsVegan(bool $isVegan): self
    {
        $this->isVegan = $isVegan;

        return $this;
    }

    public function setCreatedAtMin(DateTimeInterface $createdAtMin): self
    {
        if (
            null !== $this->createdAtMax
            && $createdAtMin >= $this->createdAtMax
        ) {
            throw new InvalidArgumentException(
                sprintf(
                    'createdAtFrom(%s) must be less than createdAtTo(%s)',
                    $createdAtMin->format(self::DATETIME_FORMAT),
                    $this->createdAtMax->format(self::DATETIME_FORMAT)
                )
            );
        }
        $this->createdAtMin = $createdAtMin;

        return $this;
    }

    public function setCreatedAtMax(DateTimeInterface $createdAtMax): self
    {
        if (
            null !== $this->createdAtMin
            && $createdAtMax <= $this->createdAtMin
        ) {
            throw new InvalidArgumentException(
                sprintf(
                    'createdAtMax(%s) must be more than createdAtMin(%s)',
                    $createdAtMax->format(self::DATETIME_FORMAT),
                    $this->createdAtMin->format(self::DATETIME_FORMAT)
                )
            );
        }
        $this->createdAtMax = $createdAtMax;

        return $this;
    }
}