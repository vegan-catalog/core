<?php

declare(strict_types=1);

namespace VeganCatalog\Core;

use DateTimeInterface;
use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;

final class Specification
{
    private const DATETIME_FORMAT = DateTimeInterface::ATOM;

    private ?IdCollection $ids = null;
    private ?bool $isVegan = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?DateTimeInterface $updatedAtMin = null;
    private ?DateTimeInterface $updatedAtMax = null;
    private ?DateTimeInterface $createdAtMin = null;
    private ?DateTimeInterface $createdAtMax = null;

    public function ids(): ?IdCollection
    {
        return $this->ids;
    }

    public function isVegan(): ?bool
    {
        return $this->isVegan;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function updatedAtMin(): ?DateTimeInterface
    {
        return $this->updatedAtMin;
    }

    public function updatedAtMax(): ?DateTimeInterface
    {
        return $this->updatedAtMax;
    }

    public function createdAtMin(): ?DateTimeInterface
    {
        return $this->createdAtMin;
    }

    public function createdAtMax(): ?DateTimeInterface
    {
        return $this->createdAtMax;
    }

    public function setIds(IdCollection $ids): self
    {
        $this->ids = $ids;

        return $this;
    }

    public function setIsVegan(bool $isVegan): self
    {
        $this->isVegan = $isVegan;

        return $this;
    }

    public function setTitle(string $title): self
    {
        if (trim($title) === '') {
            throw new InvalidArgumentException(
                sprintf(
                    'Title can\'t be empty, "%s" given',
                    $title
                )
            );
        }
        $this->title = $title;

        return $this;
    }

    public function setDescription(string $description): self
    {
        if (trim($description) === '') {
            throw new InvalidArgumentException(
                sprintf(
                    'Description can\'t be empty, "%s" given',
                    $description
                )
            );
        }
        $this->description = $description;

        return $this;
    }

    public function setUpdatedAtMin(DateTimeInterface $updatedAtMin): self
    {
        if (
            null !== $this->updatedAtMax
            && $updatedAtMin >= $this->updatedAtMax
        ) {
            throw new InvalidArgumentException(
                sprintf(
                    'updatedAtFrom(%s) must be less than updatedAtTo(%s)',
                    $updatedAtMin->format(self::DATETIME_FORMAT),
                    $this->updatedAtMax->format(self::DATETIME_FORMAT)
                )
            );
        }
        $this->updatedAtMin = $updatedAtMin;

        return $this;
    }

    public function setUpdatedAtMax(DateTimeInterface $updatedAtMax): self
    {
        if (
            null !== $this->updatedAtMin
            && $updatedAtMax <= $this->updatedAtMin
        ) {
            throw new InvalidArgumentException(
                sprintf(
                    'updatedAtMax(%s) must be more than updatedAtMin(%s)',
                    $updatedAtMax->format(self::DATETIME_FORMAT),
                    $this->updatedAtMin->format(self::DATETIME_FORMAT)
                )
            );
        }
        $this->updatedAtMax = $updatedAtMax;

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