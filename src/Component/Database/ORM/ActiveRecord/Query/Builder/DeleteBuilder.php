<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query\Builder;

use Laventure\Component\Database\ORM\ActiveRecord\Query\HasConditionInterface;
use Laventure\Component\Database\ORM\ActiveRecord\Query\HasConditions;


/**
 * @inheritdoc
*/
class DeleteBuilder implements HasConditionInterface
{
         use HasConditions;


         public function __construct()
         {
         }
}