<?php

declare(strict_types=1);

namespace VeganCatalog\Core;

use DateTimeInterface;

final class Product
{
    private Id $id;
    private bool $isVegan;
    private string $name;
    private Category $category;
    private SourceCollection $sources;
    private DateTimeInterface $createdAt;
    private DateTimeInterface $updatedAt;

    public function __construct(
        Id $id,
        bool $isVegan,
        string $name,
        Category $category,
        SourceCollection $sources,
        DateTimeInterface $createdAt,
        DateTimeInterface $updatedAt,
    ) {
        $this->id = $id;
        $this->isVegan = $isVegan;
        $this->name = $name;
        $this->category = $category;
        $this->sources = $sources;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function id(): Id
    {
        return$this->id;
    }

    public function isVegan(): bool
    {
        return $this->isVegan;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function category(): Category
    {
        return $this->category;
    }

    public function sources(): SourceCollection
    {
        return $this->sources;
    }

    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function updatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }
}