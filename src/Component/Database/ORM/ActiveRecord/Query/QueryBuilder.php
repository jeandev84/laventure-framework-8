<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;

use Laventure\Component\Database\Builder\SQL\Commands\DML\Delete;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Insert;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Update;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\Builder\SQL\SqlQueryBuilder;


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


    /**
     * @param SqlQueryBuilder $builder
     *
     * @param string $table
     *
     * @param string $model
     *
     * @param string $alias
     */
    public function __construct(
        protected SqlQueryBuilder $builder,
        protected string $table,
        protected string $model,
        protected string $alias = ''
    )
    {
    }





    /**
     * @param array|string|null $selects
     *
     * @return Select
     */
    public function select(array|string $selects = null): Select
    {
        return $this->builder->select($selects)
                             ->map($this->model)
                             ->from($this->table, $this->alias);
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