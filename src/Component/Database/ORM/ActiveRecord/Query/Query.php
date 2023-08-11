<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;

use Laventure\Component\Database\Builder\SQL\Commands\DML\Delete;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Insert;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Update;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\Builder\SQL\JoinType;
use Laventure\Component\Database\Builder\SQL\SqlQueryBuilder;
use Laventure\Component\Database\Connection\ConnectionInterface;


/**
 * @Query
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\ActiveRecord\Query
 */
class Query
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
     * @var array
    */
    protected array $wheres = [
        'AND' => [],
        'OR'  => []
    ];






    /**
     * @var Select
    */
    protected Select $selects;




    /**
     * @param ConnectionInterface $connection
     *
     * @param string $table
     *
     * @param string $classname
     *
     * @param string $alias
     *
     * @param string $primaryKey
    */
    public function __construct(
        ConnectionInterface $connection,
        string $table,
        string $classname,
        string $alias = '',
        string $primaryKey = ''
    )
    {
          $this->builder    = new SqlQueryBuilder($connection);
          $this->table      = $table;
          $this->primaryKey = $primaryKey;
          $this->selects   = $this->builder->select();
          $this->selects->from($table, $alias);
          $this->selects->map($classname);
    }


    /**
     * @param array|string|null $selects
     *
     * @return $this
    */
    public function select(array|string $selects = null): static
    {
         $selects = is_array($selects) ? join(', ', $selects) : $selects;

         return $this->addSelect($selects);
    }




    /**
     * @param string $table
     *
     * @param string $alias
     *
     * @return $this
    */
    public function from(string $table, string $alias = ''): static
    {
        $this->selects->from($table, $alias);

        return $this;
    }






    /**
     * @param string $selects
     *
     * @return $this
    */
    public function addSelect(string $selects): static
    {
        $this->selects->addSelect($selects);

        return $this;
    }






    /**
     * @param bool $distinct
     *
     * @return $this
    */
    public function distinct(bool $distinct): static
    {
         $this->selects->distinct($distinct);

         return $this;
    }





    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @param string $type
     *
     * @return $this
     */
    public function join(string $table, string $condition, string $type = JoinType::JOIN): static
    {
         $this->selects->join($table, $condition, $type);

         return $this;
    }






    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
    */
    public function leftJoin(string $table, string $condition): static
    {
         $this->selects->leftJoin($table, $condition);

         return $this;
    }





    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
    */
    public function rightJoin(string $table, string $condition): static
    {
        $this->selects->rightJoin($table, $condition);

        return $this;
    }






    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
    */
    public function fullJoin(string $table, string $condition): static
    {
        $this->selects->fullJoin($table, $condition);

        return $this;
    }





    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
    */
    public function innerJoin(string $table, string $condition): static
    {
        $this->selects->innerJoin($table, $condition);

        return $this;
    }






    /**
     * @param string $column
     *
     * @param string $direction
     *
     * @return $this
    */
    public function orderBy(string $column, string $direction = 'asc'): static
    {
        $this->selects->orderBy($column, $direction);

        return $this;
    }





    /**
     * @param string $column
     *
     * @return $this
    */
    public function groupBy(string $column): static
    {
        $this->selects->groupBy($column);

        return $this;
    }







    /**
     * @param string $condition
     *
     * @return $this
    */
    public function having(string $condition): static
    {
        $this->selects->having($condition);

        return $this;
    }





    /**
     * @param int $limit
     *
     * @return $this
    */
    public function limit(int $limit): static
    {
        $this->selects->limit($limit);

        return $this;
    }







    /**
     * @param int $limit
     *
     * @return $this
    */
    public function offset(int $limit): static
    {
        $this->selects->limit($limit);

        return $this;
    }





    /**
     * @param string $column
     *
     * @param $value
     *
     * @param string $operator
     *
     * @return $this
    */
    public function where(string $column, $value, string $operator = "="): static
    {
          return $this;
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