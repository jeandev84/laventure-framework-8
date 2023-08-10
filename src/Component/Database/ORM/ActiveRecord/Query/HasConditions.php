<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;

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
      protected array $operators = [
          '=',
          '>',
          '>=',
          '<',
          '>=',
          'LIKE'
      ];







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
     * @param string $column
     *
     * @param array $value
     *
     * @return $this
    */
    public function whereIn(string $column, array $value): static
    {
         return $this->where($column, $value, "IN :($column)");
    }






    /**
     * @param string $column
     *
     * @param string $value
     *
     * @return $this
    */
    public function whereLike(string $column, string $value): static
    {
        return $this->where($column, $value, "LIKE");
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