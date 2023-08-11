<?php
namespace Laventure\Component\Database\Builder\SQL;



use Laventure\Component\Database\Builder\SQL\Commands\DML\Delete;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Insert;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Update;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\Connection\ConnectionInterface;

/**
 * @SqlQueryBuilder
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL
*/
class SqlQueryBuilder implements SqlQueryBuilderInterface
{


    /**
     * @var ConnectionInterface
    */
    protected ConnectionInterface $connection;





    /**
     * @param ConnectionInterface $connection
    */
    public function __construct(ConnectionInterface $connection)
    {
         $this->connection = $connection;
    }





    /**
     * @return ConnectionInterface
    */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }




    /**
     * @inheritDoc
    */
    public function select(string $selects = null): Select
    {
         return new Select($this->connection, $selects);
    }







    /**
     * @inheritDoc
    */
    public function insert(string $table, array $attributes): Insert
    {
         $command = new Insert($this->connection, $table);
         $command->insert($attributes);
         return $command;
    }






    /**
     * @inheritDoc
    */
    public function update(string $table, array $attributes): Update
    {
         $command = new Update($this->connection, $table);
         $command->update($attributes);
         return $command;
    }






    /**
     * @inheritDoc
    */
    public function delete(string $table): Delete
    {
        return new Delete($this->connection, $table);
    }
}