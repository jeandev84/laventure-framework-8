<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query\Builder;

use Laventure\Component\Database\Builder\SQL\Commands\DML\Update;
use Laventure\Component\Database\ORM\ActiveRecord\Query\HasConditionInterface;
use Laventure\Component\Database\ORM\ActiveRecord\Query\HasConditions;


/**
 * @inheritdoc
*/
class UpdateBuilder implements HasConditionInterface
{

     use HasConditions;



     /**
      * @param Update $builder
     */
     public function __construct(protected Update $builder)
     {
     }





     /**
      * @return int|bool
     */
     public function execute(): int|bool
     {
          return $this->builder->execute();
     }
}