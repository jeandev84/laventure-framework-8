<?php
namespace Laventure\Component\Database\Builder\SQL\Commands;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Extensions\PDO\PdoConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;


/**
 * @SQlBuilder
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands
*/
abstract class SQlBuilder
{


       /**
        * @var ConnectionInterface
       */
       protected ConnectionInterface $connection;



       /**
        * @var string
       */
       protected string $table;




       /**
        * @param ConnectionInterface $connection
        *
        * @param string $table
      */
      public function __construct(ConnectionInterface $connection, string $table)
      {
            $this->connection = $connection;
            $this->table      = $table;
      }






      /**
       * @return string
      */
      public function getTable(): string
      {
           return $this->table;
      }







      /**
       * @return ConnectionInterface
      */
      protected function getConnection(): ConnectionInterface
      {
           return $this->connection;
      }






      /**
       * @return bool
      */
      protected function hasPdoConnection(): bool
      {
           return $this->connection instanceof PdoConnectionInterface;
      }





       /**
        * @return QueryInterface
       */
       protected function statement(): QueryInterface
       {
           return $this->connection->statement($this->getSQL());
       }

       



       /**
        * @return string
       */
       abstract public function getSQL(): string;
}