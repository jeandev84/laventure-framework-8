<?php
namespace Laventure\Component\Database\Builder\SQL\Commands;


/**
 * @inheritdoc
*/
abstract class SQLBuilderHasConditions extends SQlBuilder implements HasCriteriaInterface
{
      use HasConditions;


     /**
      * @inheritDoc
     */
     public function criteria(array $wheres): static
     {
         foreach ($wheres as $column => $value) {
             if ($this->hasPdoConnection()) {
                 if (is_array($value)) {
                      $this->where($this->expr()->in($column, "(:$column)"));
                 } else {
                     $this->where("$column = :$column");
                 }
             } else {
                 $this->where("$column = '$value'");
             }
         }

         return $this->setParameters($wheres);
     }





     /**
      * @param string $name
      *
      * @param $value
      *
      * @return $this
     */
     public function setParameter(string $name, $value): static
     {
         return parent::setParameter($name, $value);
     }






     /**
      * @param array $parameters
      *
      * @return $this
     */
     public function setParameters(array $parameters): static
     {
         return parent::setParameters($parameters);
     }
}