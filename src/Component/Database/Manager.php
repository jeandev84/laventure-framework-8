<?php
namespace Laventure\Component\Database;

use Closure;
use Exception;
use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\Connection\Configuration\Configuration;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Manager\DatabaseManager;
use Laventure\Component\Database\Migration\Migrator;
use Laventure\Component\Database\ORM\Persistence\EntityManager;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepository;
use Laventure\Component\Database\Schema\Schema;

/**
 * @inheritdoc
*/
class Manager extends DatabaseManager
{

       /**
        * @var static
       */
       protected static $instance;




       /**
        * @var array
       */
       protected static $credentials;





       /**
        * @var EntityManager|null
       */
       protected ?EntityManager $em = null;







       /**
        * @param array $credentials
        *
        * @return void
       */
       public function addConnections(array $credentials): void
       {
            $config = new Configuration($credentials);

            if (! $config->has('connection')) {
                $this->abortIf("undefined param [connection]");
            }

            if (! $config->has('connections')) {
                 $this->abortIf("undefined param [connections]");
            }

            $this->open($config['connection'], $config['connections']);
            self::$credentials = $credentials;
       }






       /**
        * @return static
       */
       public static function capsule(): static
       {
            if (! self::$instance) {
                $instance = new static();
                if (! self::$credentials) {
                    $instance->abortIf("no connections params added.");
                }
                $instance->open(self::$credentials['connection'], self::$credentials['connections']);
                self::$instance = $instance;
            }

            return self::$instance;
       }






       /**
        * @param EntityManager $em
        *
        * @return $this
       */
       public function setEntityManager(EntityManager $em): static
       {
             $this->em = $em;

             return $this;
       }





       /**
        * @return EntityManager
       */
       public function getEntityManager(): EntityManager
       {
           if (! $this->em) {
               $this->abortIf("no entity manager detected.");
           }

           return $this->em;
       }






       /**
        * @param string $classname
        *
        * @return EntityRepository
       */
       public function getRepository(string $classname): EntityRepository
       {
            return $this->em->getRepository($classname);
       }








       /**
        * @param string $sql
        *
        * @param array $params
        *
        * @return QueryInterface
       */
       public function statement(string $sql, array $params = []): QueryInterface
       {
             return $this->connection()->statement($sql, $params);
       }







      /**
       * @param string $sql
       *
       * @return bool
       */
       public function exec(string $sql): bool
       {
            return $this->connection()->exec($sql);
       }






       /**
        * @param string|null $name
        *
        * @return Schema
       */
       public function schema(string $name = null): Schema
       {
            return new Schema($this->connection($name));
       }






       /**
        * @param string|null $name
        *
        * @return Migrator
       */
       public function migrator(string $name = null): Migrator
       {
            return new Migrator($this->connection($name));
       }





       /**
        * @param string|null $name
        *
        * @return Builder
       */
       public function QB(string $name = null): Builder
       {
            return new Builder($this->connection($name));
       }




       /**
        * @param Closure $func
        *
        * @return void
       */
       public function transaction(Closure $func): void
       {
            $this->connection()->beginTransaction();

            try {
                $func($this);
                $this->connection()->commit();
            } catch (Exception $e) {
                $this->connection()->rollback();
                $this->close();
                $this->abortIf($e->getMessage());
            }
       }


       
       
       
       
       /**
        * @param string|null $name
        * 
        * @return void
       */
       public function disconnect(string $name = null): void
       {
            $this->connection($name)->disconnect();
       }


       
       
       
       
       
       
       /**
        * @param string|null $name
        * 
        * @return void
       */
       public function reconnect(string $name = null): void
       {
            $this->connection($name)->reconnect();
       }


       
       
       
       
       
       
       
       /**
        * @param string|null $name
        * @return void
       */
       public function purge(string $name = null): void
       {
           $this->connection($name)->purge();
       }


       
       
       
       
       
       /**
        * @param string|null $name
        * 
        * @return array
       */
       public function getQueries(string $name = null): array
       {
           return $this->connection($name)->getQueries();
       }
}