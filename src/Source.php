<?php

declare(strict_types=1);

namespace VeganCatalog\Core;

use VeganCatalog\Core\Enum\Source as SourceEnum;

class Source
{
    public function __construct(
        private readonly Id $id,
        private readonly string $url,
        private readonly SourceEnum $sourceEnum,
        private readonly \DateTimeInterface $createdAt,
    ) {}
}