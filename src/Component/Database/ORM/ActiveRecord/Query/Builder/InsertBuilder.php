<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query\Builder;

use Laventure\Component\Database\Builder\SQL\Commands\DML\Insert;


/**
 * @InsertBuilder
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\ActiveRecord\Query
*/
class InsertBuilder
{

      /**
       * @param Insert $qb
      */
      public function __construct(protected Insert $qb)
      {
      }





      /**
       * @return bool|int
      */
      public function execute(): bool|int
      {
          return $this->qb->execute();
      }
}