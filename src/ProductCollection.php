<?php

declare(strict_types=1);

namespace VeganCatalog\Core;

use Ramsey\Collection\AbstractCollection;

final class ProductCollection extends AbstractCollection
{
    public function getType(): string
    {
        return Product::class;
    }
}