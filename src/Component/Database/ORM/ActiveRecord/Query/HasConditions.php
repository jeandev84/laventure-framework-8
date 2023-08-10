<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;


/**
 * @HasConditions
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\ActiveRecord\Query
*/
trait HasConditions
{


      /**
       * @var array
      */
      protected array $wheres = [];




      /**
       * @var array
      */
      protected array $parameters = [];




      /**
       * @var array|string[]
      */
      protected array $operators = ['=', '>', '>=', '<', '>=', 'LIKE'];







     /**
      * @param string $column
      *
      * @param $value
      *
      * @param string $operator
      *
      * @return static
    */
    public function where(string $column, $value, string $operator = "="): static
    {
         $condition = "$column $operator :$column";

         if (! $this->hasOperator($operator)) {
             $condition = "$column $operator";
         }

         $this->wheres[$column] = $condition;

         $this->parameters[$column] = $value;

         return $this;
    }





    /**
     * @param array $wheres
     *
     * @return $this
    */
    public function wheres(array $wheres): static
    {
        foreach ($wheres as $conditions) {
            [$column, $value, $operator] = $conditions;
            $this->where($column, $value, $operator);
        }

        return $this;
    }






    /**
     * @param string $column
     *
     * @param array $data
     *
     * @return $this
    */
    public function whereIn(string $column, array $data): static
    {
         return $this->where($column, $data, "IN :($column)");
    }






    /**
     * @param array $wheres
     *
     * @return $this
    */
    public function wheresIn(array $wheres): static
    {
        foreach ($wheres as $whereIn) {
            [$column, $data] = $whereIn;
            $this->whereIn($column, $data);
        }

        return $this;
    }







    /**
     * @param string $column
     *
     * @param string $expression
     *
     * @return $this
    */
    public function whereLike(string $column, string $expression): static
    {
        return $this->where($column, $expression, "LIKE");
    }









    /**
     * @param array $wheres
     *
     * @return $this
    */
    public function wheresLike(array $wheres): static
    {
        foreach ($wheres as $whereLike) {
            [$column, $expression] = $whereLike;
            $this->whereLike($column, $expression);
        }

        return $this;
    }





    /**
     * @param string $operator
     *
     * @return bool
    */
    protected function hasOperator(string $operator): bool
    {
        return in_array($operator, $this->operators);
    }
}