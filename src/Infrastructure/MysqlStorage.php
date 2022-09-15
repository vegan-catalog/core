<?php

declare(strict_types=1);

namespace VeganCatalog\Product\Infrastructure;

use DateTimeImmutable;
use PDO;
use Ramsey\Uuid\Uuid;
use VeganCatalog\Product\Domain\Article;
use VeganCatalog\Product\Domain\Collection;
use VeganCatalog\Product\Domain\Specification;
use VeganCatalog\Product\Domain\StorageInterface;

final class MysqlStorage implements StorageInterface
{
    private const TABLE = 'products';
    private const CREATED_AT_FORMAT = 'Y-m-d H:i:s.u';
    // fields
    private const FIELD_ID = 'id';
    private const FIELD_IS_VEGAN = 'is_vegan';
    private const FIELD_CREATED_AT = 'created_at';

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Article $article): bool
    {
        $query = sprintf(
            'INSERT INTO %s (
                %s,
                %s,
                %s
            ) VALUES (
                      :id,
                      :isVegan,
                      :created_at
            )ON DUPLICATE KEY UPDATE
                %s = :isVegan
            ',
            self::TABLE,
            self::FIELD_ID,
            self::FIELD_IS_VEGAN,
            self::FIELD_CREATED_AT,
            self::FIELD_IS_VEGAN,
        );

        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $article->uuid()->getBytes());
        $statement->bindValue(':isVegan', $article->isVegan(), PDO::PARAM_BOOL);
        $statement->bindValue(':created_at', $article->createdAt()->format(self::CREATED_AT_FORMAT));

        return $statement->execute();
    }

    /**
     * @throws \Exception
     */
    public function find(Specification $specification): Collection
    {
        $collection = new Collection();
        $statement = $this->db->query(
            sprintf(
                'SELECT %s, %s, %s FROM %s WHERE %s',
                self::FIELD_ID,
                self::FIELD_IS_VEGAN,
                self::FIELD_CREATED_AT,
                self::TABLE,
                $this->buildWhere($specification),
            )
        );

        while ($article = $statement->fetch(PDO::FETCH_ASSOC)) {
            $collection->add(
                new Article(
                    Uuid::fromBytes($article[self::FIELD_ID]),
                    (bool)$article[self::FIELD_IS_VEGAN],
                    new DateTimeImmutable($article[self::FIELD_CREATED_AT]),
                )
            );
        }

        return $collection;
    }

    public function delete(Specification $specification): int
    {
        return $this->db->exec(
            sprintf(
                'DELETE FROM %s WHERE %s',
                self::TABLE,
                $this->buildWhere($specification),
            )
        );
    }

    public function createTableIfNotExists(): void
    {
        $this->db->exec(
            sprintf(
                'CREATE TABLE IF NOT EXISTS %s (
                    %s BINARY(16) PRIMARY KEY,
                    %s BOOLEAN NOT NULL,
                    %s TIMESTAMP(6) NOT NULL
                )',
                self::TABLE,
                self::FIELD_ID,
                self::FIELD_IS_VEGAN,
                self::FIELD_CREATED_AT,
            )
        );
    }

    private function buildWhere(Specification $specification): string
    {
        $where = [];

        if ($specification->ids() !== null) {
            $where[] = sprintf(
                '%s IN (%s)',
                self::FIELD_ID,
                implode(
                    ',',
                    array_map(
                        static fn ($id) => sprintf('UUID_TO_BIN(\'%s\')', $id),
                        $specification->ids()
                    )
                )
            );
        }

        if ($specification->isVegan() !== null) {
            $where[] = sprintf(
                '%s = %d',
                self::FIELD_IS_VEGAN,
                $specification->isVegan()
            );
        }

        if ($specification->createdAtMin() !== null) {
            $where[] = sprintf(
                '%s >= %s',
                self::FIELD_CREATED_AT,
                $specification->createdAtMin()->format(self::CREATED_AT_FORMAT)
            );
        }

        if ($specification->createdAtMax() !== null) {
            $where[] = sprintf(
                '%s <= %s',
                self::FIELD_CREATED_AT,
                $specification->createdAtMax()->format(self::CREATED_AT_FORMAT)
            );
        }

        return implode(' AND ', $where);
    }
}