<?php

declare(strict_types=1);

namespace VeganCatalog\Core;

use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

class Id
{
    private UuidInterface $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function fromString(string $uuidString): self
    {
        return new self(
            (new UuidFactory())
                ->fromString($uuidString)
        );
    }

    public static function another(): self
    {
        return self::fromString(bin2hex(random_bytes(16)));
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }
}