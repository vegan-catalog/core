<?php

namespace VeganCatalog\Product\Domain;

interface StorageInterface
{
    public function find(Specification $specification): Collection;
    public function save(Article $article): bool;
    public function delete(Specification $specification): int;
}
