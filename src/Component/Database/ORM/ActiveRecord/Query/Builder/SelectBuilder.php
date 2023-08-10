<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query\Builder;

use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\ORM\ActiveRecord\Query\HasConditionInterface;
use Laventure\Component\Database\ORM\ActiveRecord\Query\HasConditions;


/**
 * @SelectBuilder
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Query\ActiveRecord
*/
class SelectBuilder implements HasConditionInterface
{


    use HasConditions;


    /**
     * @var Select
    */
    protected Select $builder;




    /**
     * @var string
    */
    protected string $classname;




    /**
     * @param Select $builder
     *
     * @param string $classname
    */
    public function __construct(Select $builder, string $classname)
    {
         $this->builder   = $builder;
         $this->builder->map($classname);
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
        $this->builder->from($table, $alias);

        return $this;
    }






    /**
     * @param array|string|null $selects
     *
     * @return $this
    */
    public function addSelect(array|string $selects = null): static
    {
         $selects = is_array($selects) ? join(', ', $selects) : $selects;

         $this->builder->addSelect($selects);

         return $this;
    }





    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
    */
    public function join(string $table, string $condition): static
    {
          $this->builder->join($table, $condition);

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
         $this->builder->leftJoin($table, $condition);

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
        $this->builder->rightJoin($table, $condition);

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
         $this->builder->innerJoin($table, $condition);

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
        $this->builder->fullJoin($table, $condition);

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
        $this->builder->orderBy($column, $direction);

        return $this;
    }





    /**
     * @param string $column
     *
     * @return $this
     */
    public function groupBy(string $column): static
    {
        $this->builder->groupBy($column);

        return $this;
    }







    /**
     * @param string $condition
     *
     * @return $this
    */
    public function having(string $condition): static
    {
         $this->builder->having($condition);

         return $this;
    }



    /**
     * @param int $limit
     *
     * @return $this
    */
    public function limit(int $limit): static
    {
         $this->builder->limit($limit);

         return $this;
    }






    /**
     * @param int $limit
     *
     * @return $this
    */
    public function offset(int $limit): static
    {
        $this->builder->limit($limit);

        return $this;
    }






    /**
     * @return object[]
    */
    public function get(): array
    {
         return $this->builder->fetch()->all();
    }







    /**
     * @return mixed
    */
    public function one(): mixed
    {
        return $this->builder->fetch()->one();
    }
}