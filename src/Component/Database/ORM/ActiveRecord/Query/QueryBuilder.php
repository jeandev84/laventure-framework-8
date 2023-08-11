<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;

use Laventure\Component\Database\Builder\SQL\Commands\DML\Delete;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Insert;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Update;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\Builder\SQL\SqlQueryBuilder;
use Laventure\Component\Database\Connection\ConnectionInterface;


/**
 * @QueryBuilder
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\ActiveRecord\Query
 */
class QueryBuilder
{


    protected SqlQueryBuilder $builder;



    /**
     * @var string
    */
    protected string $table;



    /**
     * @var string
    */
    protected string $alias = '';



    /**
     * @var string
    */
    protected string $classname;




    /**
     * @var string
    */
    protected string $primaryKey;




    /**
     * @param ConnectionInterface $connection
     *
     * @param string $table
     *
     * @param string $classname
    */
    public function __construct(ConnectionInterface $connection, string $table, string $classname)
    {
          $this->builder   = new SqlQueryBuilder($connection);
          $this->table     = $table;
          $this->classname = $classname;
    }





    /**
     * @param string $primaryKey
     *
     * @return $this
    */
    public function primaryKey(string $primaryKey): static
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }






    /**
     * @param string $alias
     *
     * @return $this
    */
    public function alias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }






    /**
     * @param array|string|null $selects
     *
     * @param array $criteria
     *
     * @return Select
    */
    public function select(array|string $selects = null, array $criteria = []): Select
    {
         $qb = $this->builder->select($selects);
         $qb->from($this->table, $this->alias);
         $qb->map($this->classname);
         $qb->criteria($criteria);
         return $qb;
    }







    /**
     * @param array $attributes
     *
     * @return Insert
     */
    public function create(array $attributes): Insert
    {
        return $this->builder->insert($this->table, $attributes);
    }





    /**
     * @param array $attributes
     *
     * @param array $wheres
     *
     * @return Update
    */
    public function update(array $attributes, array $wheres): Update
    {
        return $this->builder->update($this->table, $attributes, $wheres);
    }






    /**
     * @param array $wheres
     *
     * @return Delete
    */
    public function delete(array $wheres): Delete
    {
        return $this->builder->delete($this->table, $wheres);
    }
}