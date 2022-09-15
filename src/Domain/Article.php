<?php

declare(strict_types=1);

namespace VeganCatalog\Product\Domain;

use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Article
{
    private UuidInterface $uuid;
    private bool $isVegan;
    private DateTimeInterface $createdAt;

    public function __construct(
        ?UuidInterface $uuid,
        bool $isVegan,
        DateTimeInterface $createdAt,
    ) {
        $this->uuid = $uuid ?? Uuid::uuid4();
        $this->isVegan = $isVegan;
        $this->createdAt = $createdAt;
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function isVegan(): bool
    {
        return $this->isVegan;
    }

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}