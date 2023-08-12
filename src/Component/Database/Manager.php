<?php
namespace Laventure\Component\Database;

use Closure;
use Exception;
use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\Connection\Configuration\Configuration;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Extensions\PDO\PdoConnectionInterface;
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
            if (! self::$instance) {
                $this->config = new Configuration($config);
                $connection   = $this->config->required('connection');
                $credentials  = $this->config->required('configurations');
                $this->open($connection, $credentials);
                self::$instance = $this;
            }
       }





       /**
        * @return static
       */
       public static function capsule(): static
       {
           if (! self::$instance) {
               throw new \RuntimeException("No connection to database detected in:". get_called_class());
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
            return $this->getEntityManager()->getRepository($classname);
       }







       /**
        * @param string|null $name
       */
       public function pdoConnection(string $name = null): ConnectionInterface
       {
           $connection = $this->connection($name);

           if (! $connection instanceof PdoConnectionInterface) {
                throw new \RuntimeException("no pdo connection detected.");
           }

           return $connection;
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
       public function createQB(string $name = null): Builder
       {
            return new Builder($this->connection($name));
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
        * @return string
       */
       private function migrationTable(): string
       {
           return $this->config()->get('migration.table', 'migrations');
       }
}