<?php
namespace Laventure\Component\Database\Schema;

use Closure;
use Laventure\Component\Database\Connection\ConnectionInterface;

/**
 * @inheritdoc
*/
class Schema implements SchemaInterface
{


    /**
     * @param ConnectionInterface $connection
    */
    public function __construct(protected ConnectionInterface $connection)
    {
    }




    /**
     * @inheritDoc
    */
    public function create(string $table, Closure $closure): mixed
    {

    }





    /**
     * @inheritDoc
    */
    public function update(string $table, Closure $closure): mixed
    {
        // TODO: Implement update() method.
    }






    /**
     * @inheritDoc
    */
    public function drop(string $table): mixed
    {
        // TODO: Implement drop() method.
    }




    /**
     * @inheritDoc
    */
    public function dropIfExists(string $table): mixed
    {
        // TODO: Implement dropIfExists() method.
    }




    /**
     * @inheritDoc
    */
    public function truncate(string $table): mixed
    {
        // TODO: Implement truncate() method.
    }





    /**
     * @inheritDoc
    */
    public function truncateCascade(string $table): mixed
    {
        // TODO: Implement truncateCascade() method.
    }






    /**
     * @inheritDoc
    */
    public function describe(string $table): mixed
    {
        // TODO: Implement describe() method.
    }





    /**
     * @inheritDoc
    */
    public function getColumns(string $table): array
    {
        // TODO: Implement getColumns() method.
    }




    /**
     * @inheritDoc
    */
    public function exists(string $table): bool
    {
        // TODO: Implement exists() method.
    }





    /**
     * @inheritDoc
    */
    public function getTables(): array
    {
        // TODO: Implement getTables() method.
    }
}