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
        * @var array
       */
       protected array $parameters = [];





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
       * @param string $name
       *
       * @param $value
       *
       * @return $this
      */
      public function setParameter(string $name, $value): static
      {
           $this->parameters[$name] = $value;

           return $this;
      }





      /**
       * @param array $parameters
       *
       * @return SQlBuilder
      */
      public function setParameters(array $parameters): static
      {
           $this->parameters = array_merge($this->parameters, $parameters);

           return $this;
      }





      /**
       * Returns parameters
       *
       * @return array
      */
      public function getParameters(): array
      {
           return $this->parameters;
      }






      /**
       * @return string
      */
      public function getTable(): string
      {
           return $this->table;
      }





      /**
       * @param array $attributes
       *
       * @return array
      */
      protected function resolveBindingParameters(array $attributes): array
      {
           $resolved = [];

           foreach ($attributes as $column => $value) {
              if ($this->hasPdoConnection()) {
                 $resolved[] = "$column = :$column";
              } else {
                 $resolved[] = "$column = '$value'";
              }
           }

           return $resolved;
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
           return $this->connection->statement($this->getSQL(), $this->getParameters());
       }

       



       /**
        * @return string
       */
       abstract public function getSQL(): string;
}