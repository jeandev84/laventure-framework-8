<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;

use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\Builder\SQL\SqlQueryBuilder;
use Laventure\Component\Database\ORM\ActiveRecord\Query\Builder\DeleteBuilder;
use Laventure\Component\Database\ORM\ActiveRecord\Query\Builder\InsertBuilder;
use Laventure\Component\Database\ORM\ActiveRecord\Query\Builder\SelectBuilder;
use Laventure\Component\Database\ORM\ActiveRecord\Query\Builder\UpdateBuilder;


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
     * @return InsertBuilder
    */
    public function create(array $attributes): InsertBuilder
    {
         return new InsertBuilder($this->builder->insert($this->table, $attributes));
    }





    /**
     * @param array $attributes
     *
     * @param array $wheres
     *
     * @return UpdateBuilder
    */
    public function update(array $attributes, array $wheres): UpdateBuilder
    {
         return new UpdateBuilder($this->builder->update($this->table, $attributes, $wheres));
    }






    /**
     * @param array $wheres
     *
     * @return DeleteBuilder
    */
    public function delete(array $wheres): DeleteBuilder
    {
        return new DeleteBuilder($this->builder->delete($this->table, $wheres));
    }
}