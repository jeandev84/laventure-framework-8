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
         $binding = is_array($value) ? "(:$column)" : ":$column";

         $this->wheres[$column] = "$column $operator $binding";

         $this->parameters[$column] = $value;

         return $this;
    }





    /**
     * @return array
    */
    public function getParameters(): array
    {
        return $this->parameters;
    }






    /**
     * @return array
    */
    public function getConditions(): array
    {
        return $this->wheres;
    }
}