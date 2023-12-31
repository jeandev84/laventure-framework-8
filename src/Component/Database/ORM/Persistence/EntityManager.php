<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Closure;
use Exception;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence\ObjectPersistenceInterface;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\ORM\Persistence\Manager\EntityManagerInterface;
use Laventure\Component\Database\ORM\Persistence\Manager\EventManager;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PreFlushEvent;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadataFactory;
use Laventure\Component\Database\ORM\Persistence\Query\QueryBuilder;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepository;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepositoryFactory;



/**
 * @inheritdoc
*/
class EntityManager implements EntityManagerInterface, ObjectPersistenceInterface
{

    /**
     * @var ConnectionInterface
    */
    protected ConnectionInterface $connection;




    /**
     * @var Definition
    */
    protected Definition $definition;




    /**
     * @var EventManager
    */
    protected EventManager $eventManager;




    /**
     * @var UnitOfWork
    */
    protected UnitOfWork $unitOfWork;





    /**
     * @var ClassMetadataFactory
    */
    protected ClassMetadataFactory $metadataFactory;





    /**
     * @var EntityRepositoryFactory
    */
    protected EntityRepositoryFactory $repositoryFactory;






    /**
     * @var bool
    */
    protected bool $closed = false;





    /**
     * @var array
    */
    protected array $initialized = [];





    /**
     * @var array
    */
    protected array $managed = [];




    /**
     * @var EntityRepository[]
    */
    protected array $repositories = [];








    /**
     * @param ConnectionInterface $connection
     *
     * @param Definition $definition
     *
     * @param EventManager $eventManager
    */
    public function __construct(ConnectionInterface $connection, Definition $definition, EventManager $eventManager)
    {
        $this->connection        = $connection;
        $this->definition        = $definition;
        $this->eventManager      = $eventManager;
        $this->metadataFactory   = $definition->getMetadataFactory();
        $this->repositoryFactory = $definition->getRepositoryFactory();
        $this->unitOfWork        = new UnitOfWork($this);
    }








    /**
     * @inheritDoc
    */
    public function isOpen(): bool
    {
        return ! $this->closed;
    }









    /**
     * @inheritDoc
    */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }






    /**
     * @inheritDoc
    */
    public function getUnitOfWork(): UnitOfWork
    {
        return $this->unitOfWork;
    }





    /**
     * @inheritDoc
    */
    public function getEventManager(): EventManager
    {
        return $this->eventManager;
    }





    /**
     * @inheritDoc
    */
    public function find(string $classname, $id): mixed
    {
        return $this->getUnitOfWork()->getPersistence($classname)->find($id);
    }







    /**
     * @inheritDoc
    */
    public function getRepository(string $classname): EntityRepository
    {
         if (isset($this->repositories[$classname])) {
             return $this->repositories[$classname];
         }

         if (! $repository = $this->repositoryFactory->createRepository($classname)) {
               $repository = new EntityRepository($this, new ClassMetadata($classname));
         }

         return $this->repositories[$classname] = $repository;
    }








    /**
     * @inheritDoc
    */
    public function createQueryBuilder(): QueryBuilder
    {
         return new QueryBuilder($this);
    }







     /**
      * @inheritDoc
     */
     public function beginTransaction(): bool
     {
         return $this->connection->beginTransaction();
     }






     /**
      * @inheritDoc
     */
     public function commit(): bool
     {
         return $this->connection->commit();
     }






     /**
      * @inheritDoc
     */
     public function rollback(): bool
     {
         return $this->connection->rollback();
     }







     /**
      * @inheritDoc
     */
     public function transaction(Closure $func): void
     {
         $this->beginTransaction();

         try {
             $func($this);
             $this->commit();
         } catch (Exception $e) {
             $this->close();
             $this->rollback();
             trigger_error($e->getMessage());
         }
     }







    /**
     * @inheritDoc
    */
    public function persist(object $object): void
    {
        $this->unitOfWork->persist($object);
    }





    /**
     * @inheritDoc
    */
    public function remove(object $object): void
    {
        $this->unitOfWork->remove($object);
    }






    /**
     * @inheritDoc
    */
    public function clear(): void
    {
        $this->unitOfWork->clear();
    }





    /**
     * @inheritDoc
    */
    public function detach(object $object): void
    {
        $this->unitOfWork->detach($object);
    }





    /**
     * @inheritDoc
    */
    public function refresh(object $object): void
    {
        $this->unitOfWork->refresh($object);
    }




    /**
     * @inheritDoc
     */
    public function initialize(object $object): void
    {
        $this->unitOfWork->attach($object);
        $this->initialized[get_class($object)] = $object;
    }





    /**
     * @inheritDoc
     */
    public function contains(object $object): bool
    {
        return $this->unitOfWork->contains($object);
    }





    /**
     * @inheritDoc
     */
    public function persistence(array $objects): static
    {
        foreach ($objects as $object) {
            if (! is_object($object)) {
                continue;
            }

            $this->persist($object);
            $this->managed[get_class($object)] = $object;
        }

        return $this;
    }







    /**
     * @inheritDoc
     */
    public function getClassMetadata($classname): ClassMetadata
    {
        return $this->metadataFactory->createClassMetadata($classname);
    }






    /**
     * @return array
     */
    public function getQueries(): array
    {
        return $this->connection->getQueries();
    }






    /**
     * @return array
    */
    public function logSQL(): array
    {
        return array_filter($this->getQueries(), function (QueryInterface $statement) {
            return $statement->getLogger()->getQueriesInfo();
        });
    }






    /**
     * @inheritDoc
    */
    public function flush(): void
    {
        $this->eventManager->dispatchEvent(new PreFlushEvent($this));
        $this->unitOfWork->commit();
    }







    /**
     * @inheritDoc
    */
    public function close(): void
    {
        $this->closed = false;
        $this->connection->disconnect();
    }
}