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
         * @var Configuration
        */
        protected Configuration $config;





        /**
         * @var EntityManager|null
        */
        protected ?EntityManager $em = null;





        /**
         * @var static
        */
        protected static $instance;






        /**
         * @param array $config
       */
       public function __construct(array $config)
       {
            $this->config = new Configuration($config);
            $connection   = $this->config->required('connection');
            $credentials  = $this->config->required('configurations');

            $this->open($connection, $credentials);

            self::$instance = $this;
       }





       /**
        * @return static
       */
       public static function capture(): static
       {
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
            return $this->getEntityManager()->getRepository($classname);
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
       public function migration(string $name = null): Migrator
       {
            return new Migrator($this->connection($name), $this->migrationTable());
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
        *
        * @return void
       */
       public function purge(string $name = null): void
       {
           $this->connection($name)->purge();
       }






       /**
        * @inheritDoc
       */
       public function config(): Configuration
       {
           return $this->config;
       }








       /**
        * @inheritdoc
       */
       public function close(): void
       {
           parent::close();
           $this->config->removeAll();
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







       /**
        * @return string
       */
       private function migrationTable(): string
       {
           return $this->config()->get('migration.table', 'migrations');
       }
}