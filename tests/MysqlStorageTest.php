<?php

namespace VeganCatalog\Product\Tests;

use DateTimeImmutable;
use PDO;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use VeganCatalog\Product\Domain\Article;
use VeganCatalog\Product\Domain\Specification;
use VeganCatalog\Product\Domain\StorageInterface;
use VeganCatalog\Product\Infrastructure\MysqlStorage;

class MysqlStorageTest extends TestCase
{
    private UuidInterface $uuid;
    private StorageInterface $storage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->uuid = Uuid::uuid4();
        $this->storage = new MysqlStorage(
            new PDO(
                sprintf(
                    'mysql:dbname=%s;host=%s',
                    getenv('MYSQL_DATABASE'),
                    getenv('MYSQL_HOST'),
                ),
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD'),
            )
        );
        $this->storage->createTableIfNotExists();
    }

    public function testSaveArticle(): void
    {
        $article = new Article(
            $this->uuid,
            true,
            new DateTimeImmutable()
        );
        $this->storage->save($article);
        $collection = $this->storage->find((new Specification())->setIds([$article->uuid()]));
        static::assertEquals(1, $collection->count());
        static::assertEquals($article, $collection->getIterator()->current());
    }

    public function testRemoveArticle(): void
    {
        $specification = (new Specification())->setIds([$this->uuid]);
        $this->storage->delete($specification);
        static::assertEmpty($this->storage->find($specification)->getIterator());
    }
}
