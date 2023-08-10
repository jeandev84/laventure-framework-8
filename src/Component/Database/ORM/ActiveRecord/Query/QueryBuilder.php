<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;

use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\ORM\ActiveRecord\Query\Builder\SelectBuilder;


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
     * @param Builder $builder
     *
     * @param string $table
     *
     * @param string $model
     *
     * @param string $alias
    */
    public function __construct(
        protected Builder $builder,
        protected string $table,
        protected string $model,
        protected string $alias = ''
    )
    {
    }





    /**
     * @param array|string|null $selects
     *
     * @return SelectBuilder
    */
    public function select(array|string $selects = null): SelectBuilder
    {
         $qb = new SelectBuilder($this->builder->select($selects), $this->model);
         $qb->from($this->table, $this->alias);
         return $qb;
    }






    /**
     * @param array $attributes
     *
     * @return bool|int
    */
    public function create(array $attributes): bool|int
    {
         return $this->builder->insert($this->table, $attributes);
    }





    /**
     * @param array $attributes
     *
     * @param array $wheres
     *
     * @return bool|int
    */
    public function update(array $attributes, array $wheres): bool|int
    {
         return $this->builder->update($this->table, $attributes, $wheres);
    }






    /**
     * @param array $wheres
     *
     * @return bool
    */
    public function delete(array $wheres): bool
    {
        return $this->builder->delete($this->table, $wheres);
    }
}