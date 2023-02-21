<?php

namespace VeganCatalog\Core;

interface StorageInterface
{
    public function find(Specification $specification): ProductCollection;
    public function save(Product $product): bool;
    public function delete(Specification $specification): int;
}
