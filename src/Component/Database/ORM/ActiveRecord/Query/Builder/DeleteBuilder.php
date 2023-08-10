<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query\Builder;

use Laventure\Component\Database\Builder\SQL\Commands\DML\Delete;
use Laventure\Component\Database\ORM\ActiveRecord\Query\HasConditionInterface;
use Laventure\Component\Database\ORM\ActiveRecord\Query\HasConditions;


/**
 * @inheritdoc
*/
class DeleteBuilder implements HasConditionInterface
{
     use HasConditions;


     /**
      * @param Delete $builder
     */
     public function __construct(protected Delete $builder)
     {
     }




     /**
      * @return bool
     */
     public function execute(): bool
     {
         $this->builder->wheres($this->wheres)
                       ->setParameters($this->parameters);

          return $this->builder->execute();
     }
}