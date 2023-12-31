<?php
namespace Laventure\Component\Database\Schema;

use Closure;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Schema\Blueprint\Blueprint;
use Laventure\Component\Database\Schema\Blueprint\BlueprintFactory;

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
    public function create(string $table, Closure $closure): bool
    {
        if ($this->exists($table)) {
             return true;
        }

        $blueprint = $this->blueprint($table);

        call_user_func($closure, $blueprint);

        return $blueprint->createTable();
    }






    /**
     * @inheritDoc
    */
    public function update(string $table, Closure $closure): bool
    {
         if (! $this->exists($table)) {
             return false;
         }

         $blueprint = $this->blueprint($table);

         call_user_func($closure, $blueprint);

         return $blueprint->updateTable();
    }






    /**
     * @inheritDoc
    */
    public function drop(string $table): bool
    {
        if (! $this->exists($table)) {
            return false;
        }

        return $this->blueprint($table)->dropTable();
    }





    /**
     * @inheritDoc
    */
    public function dropIfExists(string $table): bool
    {
        return $this->blueprint($table)->dropTableIfExists();
    }




    /**
     * @inheritDoc
    */
    public function truncate(string $table): bool
    {
        if (! $this->exists($table)) {
            return false;
        }

        return $this->blueprint($table)->truncateTable();
    }





    /**
     * @inheritDoc
    */
    public function truncateCascade(string $table): mixed
    {
        if (! $this->exists($table)) {
            return false;
        }

        return $this->blueprint($table)->truncateTableCascade();
    }






    /**
     * @inheritDoc
    */
    public function getColumns(string $table): array
    {
        if (! $this->exists($table)) {
             return [];
        }

        return $this->blueprint($table)->getColumns();
    }





    /**
     * @inheritDoc
    */
    public function exists(string $table): bool
    {
        return $this->connection->hasTable($table);
    }






    /**
     * @inheritDoc
    */
    public function getTables(): array
    {
        return $this->connection->getTables();
    }






    /**
     * @inheritDoc
    */
    public function hasColumn(string $table, string $column): bool
    {
        if (! $this->exists($table)) {
            return false;
        }

        return $this->blueprint($table)->hasColumn($column);
    }







    /**
     * @inheritDoc
    */
    public function statement(string $sql, array $params = []): QueryInterface
    {
         return $this->connection->statement($sql, $params);
    }







    /**
     * @inheritDoc
    */
    public function exec(string $sql): bool
    {
        return $this->connection->exec($sql);
    }





    /**
     * @param string $table
     *
     * @return Blueprint
    */
    private function blueprint(string $table): Blueprint
    {
        return BlueprintFactory::make($this->connection, $table);
    }


}