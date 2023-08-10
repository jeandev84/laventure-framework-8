<?php
namespace Laventure\Component\Database\ORM\Persistence\Query;

use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\Builder\SQL\Commands\Expr\Expr;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\ORM\Persistence\EntityManager;
use Laventure\Component\Database\ORM\Persistence\Manager\EntityManagerInterface;

/**
 * @QueryBuilder
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\QueryBuilder
*/
class QueryBuilder extends Builder
{


      /**
       * @var EntityManager
      */
      protected EntityManager $em;




      /**
       * @param EntityManager $em
      */
      public function __construct(EntityManager $em)
      {
          parent::__construct($em->getConnection());
          $this->em = $em;
      }





      /**
       * @param string|null $selects
       *
       * @param bool $distinct
       *
       * @return Select
      */
      public function select(string $selects = null, bool $distinct = false): Select
      {
          $selection = parent::select($selects, $distinct);
          $selection->persistence($this->em);
          return $selection;
      }
}