<?php
namespace Laventure\Component\Database\Connection\Extensions\Mysqli;

use Closure;
use Laventure\Component\Database\Connection\Configuration\ConfigurationInterface;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;


/**
 * @inheritdoc
*/
class MysqliConnection implements ConnectionInterface
{

    /**
     * @inheritDoc
    */
    public function getName(): string
    {
        return 'mysqli';
    }





    /**
     * @inheritDoc
    */
    public function connect(ConfigurationInterface $config): void
    {
        // TODO: Implement connect() method.
    }





    /**
     * @inheritDoc
    */
    public function connected(): bool
    {
        // TODO: Implement connected() method.
    }





    /**
     * @inheritDoc
    */
    public function reconnect(): void
    {
        // TODO: Implement reconnect() method.
    }






    /**
     * @inheritDoc
    */
    public function disconnect(): void
    {
        // TODO: Implement disconnect() method.
    }






    /**
     * @inheritDoc
    */
    public function purge(): mixed
    {
        // TODO: Implement purge() method.
    }





    /**
     * @inheritDoc
    */
    public function disconnected(): bool
    {
        // TODO: Implement disconnected() method.
    }





    /**
     * @inheritDoc
    */
    public function createQuery(): QueryInterface
    {
        // TODO: Implement createQuery() method.
    }






    /**
     * @inheritDoc
    */
    public function statement(string $sql, array $params = []): QueryInterface
    {
        // TODO: Implement statement() method.
    }






    /**
     * @inheritDoc
    */
    public function beginTransaction(): bool
    {
        // TODO: Implement beginTransaction() method.
    }






    /**
     * @inheritDoc
    */
    public function hasActiveTransaction(): bool
    {
        // TODO: Implement hasActiveTransaction() method.
    }





    /**
     * @inheritDoc
    */
    public function commit(): bool
    {
        // TODO: Implement commit() method.
    }





    /**
     * @inheritDoc
    */
    public function rollback(): bool
    {
        // TODO: Implement rollback() method.
    }






    /**
     * @inheritDoc
    */
    public function transaction(Closure $closure): mixed
    {
        // TODO: Implement transaction() method.
    }






    /**
     * @inheritDoc
    */
    public function lastInsertId($name = null): int
    {
        // TODO: Implement lastInsertId() method.
    }






    /**
     * @inheritDoc
    */
    public function exec(string $sql): bool
    {
        // TODO: Implement exec() method.
    }





    /**
     * @inheritDoc
    */
    public function getConnection(): mixed
    {
        // TODO: Implement getConnection() method.
    }





    /**
     * @inheritDoc
    */
    public function config(): ConfigurationInterface
    {
        // TODO: Implement config() method.
    }





    /**
     * @inheritDoc
    */
    public function getDatabase(): string
    {
        // TODO: Implement getDatabase() method.
    }






    /**
     * @inheritDoc
    */
    public function getDatabases(): array
    {
        // TODO: Implement getDatabases() method.
    }





    /**
     * @inheritDoc
    */
    public function createDatabase(): mixed
    {
        // TODO: Implement createDatabase() method.
    }





    /**
     * @inheritDoc
    */
    public function dropDatabase(): mixed
    {
        // TODO: Implement dropDatabase() method.
    }







    /**
     * @inheritDoc
    */
    public function hasDatabase(): bool
    {
        // TODO: Implement hasDatabase() method.
    }






    /**
     * @inheritDoc
    */
    public function getTables(): array
    {
        // TODO: Implement getTables() method.
    }






    /**
     * @inheritDoc
    */
    public function getQueries(): array
    {
         return [];
    }
}