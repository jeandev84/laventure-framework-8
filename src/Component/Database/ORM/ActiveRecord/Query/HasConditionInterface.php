<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;

interface HasConditionInterface
{

     /**
      * @param string $column
      *
      * @param $value
      *
      * @param string $operator
      *
      * @return static
     */
     public function where(string $column, $value, string $operator = "="): static;
}