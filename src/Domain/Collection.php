<?php

declare(strict_types=1);

namespace VeganCatalog\Product\Domain;

use Ramsey\Collection\AbstractCollection;

final class Collection extends AbstractCollection
{
    public function getType(): string
    {
        return Article::class;
    }
}