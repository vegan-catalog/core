<?php

declare(strict_types=1);

namespace VeganCatalog\Core;

class Category
{
    public function __construct(
        private readonly Id $id,
        private readonly Id $parentId,
        private readonly string $name,
        private readonly \DateTimeInterface $createdAt,
    ) {}
}