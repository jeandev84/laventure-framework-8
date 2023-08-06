<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\ORM\Persistence\Manager\EntityManagerInterface;

class EntityManager implements EntityManagerInterface
{


      /**
       * @var ConnectionInterface
      */
      protected ConnectionInterface $connection;


      /**
       * @param ConnectionInterface $connection
      */
      public function __construct(ConnectionInterface $connection)
      {
           $this->connection = $connection;
      }


      /**
       * @return ConnectionInterface
      */
      public function connection(): ConnectionInterface
      {
          return $this->connection;
      }



      public function manage(string $classname)
      {

      }



      public function getTableName()
      {
          return '';
      }



      public function getClassName()
      {

      }
}