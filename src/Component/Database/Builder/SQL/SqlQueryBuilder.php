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
     * @inheritDoc
    */
    public function select(string $selects = null): Select
    {
         $select = new Select($this->connection);
         $select->addSelect($selects);
         return $select;
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
    public function update(string $table, array $attributes, array $criteria): Update
    {
         $command = new Update($this->connection, $table);
         $command->update($attributes);
         $command->criteria($criteria);
         return $command;
    }






    /**
     * @inheritDoc
    */
    public function delete(string $table, array $criteria): Delete
    {
        $command = new Delete($this->connection, $table);
        $command->criteria($criteria);
        return $command;
    }
}