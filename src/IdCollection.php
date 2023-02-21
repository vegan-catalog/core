<?php

declare(strict_types=1);

namespace VeganCatalog\Core;

use Ramsey\Collection\AbstractCollection;

final class IdCollection extends AbstractCollection
{
    public function getType(): string
    {
        return Id::class;
    }
}