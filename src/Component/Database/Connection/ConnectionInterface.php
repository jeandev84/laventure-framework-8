<?php
namespace Laventure\Component\Database\Connection;


use Closure;
use Laventure\Component\Database\Connection\Configuration\ConfigurationInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;



/**
 * @ConnectionInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection
*/
interface ConnectionInterface
{

    /**
     * Returns connection name
     *
     * @return string
    */
    public function getName(): string;





    /**
     * Connect to the database
     *
     * @param ConfigurationInterface $config
     *
     * @return void
    */
    public function connect(ConfigurationInterface $config): void;







    /**
     * Determine if the connection established
     *
     * @return bool
     */
    public function connected(): bool;







    /**
     * Reconnection to the database
     *
     * @return void
    */
    public function reconnect(): void;







    /**
     * Disconnect to the database
     *
     * @return void
    */
    public function disconnect(): void;






    /**
     * Purge connection
     *
     * @return mixed
    */
    public function purge(): mixed;






    /**
     * Determine if connection is not established
     *
     * @return bool
    */
    public function disconnected(): bool;






    /**
     * Create a native query
     *
     * @return QueryInterface
    */
    public function createQuery(): QueryInterface;








    /**
     * Prepare query
     *
     * @param string $sql
     *
     * @param array $params
     *
     * @return QueryInterface
    */
    public function statement(string $sql, array $params = []): QueryInterface;








    /**
     * Begin a transaction query
     *
     * @return bool
    */
    public function beginTransaction(): bool;






    /**
     * @return bool
    */
    public function hasActiveTransaction(): bool;






    /**
     * Commit transaction
     *
     * @return bool
    */
    public function commit(): bool;





    /**
     * Rollback transaction
     *
     * @return bool
    */
    public function rollback(): bool;





    /**
     * Transaction
     *
     * @param Closure $closure
     *
     * @return mixed
    */
    public function transaction(Closure $closure): mixed;





    /**
     * Get last insert id
     *
     * @param $name
     *
     * @return int
    */
    public function lastInsertId($name = null): int;






    /**
     * Execute query
     *
     * @param string $sql
     *
     * @return bool
    */
    public function exec(string $sql): bool;







    /**
     * Returns connection driver
     *
     * @return mixed
    */
    public function getConnection(): mixed;








    /**
     * Returns configuration
     *
     * @return ConfigurationInterface
    */
    public function config(): ConfigurationInterface;






    /**
     * Returns database name
     *
     * @return string
    */
    public function getDatabase(): string;






    /**
     * Returns databases
     *
     * @return array
    */
    public function getDatabases(): array;






    /**
     * Create database
     *
     * @return mixed
    */
    public function createDatabase(): mixed;






    /**
     * Drop database
     *
     * @return mixed
    */
    public function dropDatabase(): mixed;








    /**
     * Determine if database exists
     *
     * @return bool
    */
    public function hasDatabase(): bool;






    /**
     * Return database tables
     *
     * @return array
    */
    public function getDatabaseTables(): array;







    /**
     * @return mixed
    */
    public function getQueriesLog(): mixed;
}