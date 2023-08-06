<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Closure;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Mapping\ObjectPersistenceInterface;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\ORM\Persistence\Manager\EntityManagerInterface;
use Laventure\Component\Database\ORM\Persistence\Manager\EventManager;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadataInterface;
use Laventure\Component\Database\ORM\Persistence\Query\QueryBuilder;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepository;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepositoryFactory;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepositoryInterface;
use Laventure\Component\Database\ORM\Persistence\UnitOfWork\UnitOfWorkInterface;


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
    protected Definition $config;





    /**
     * @var UnitOfWork
    */
    protected UnitOfWork $unitOfWork;





    /**
     * @var ClassMetadata
    */
    protected ClassMetadata $metadata;






    /**
     * @var EntityRepository[]
    */
    protected array $repositories = [];




    /**
     * @var bool
    */
    protected bool $enabled = false;





    /**
     * @param ConnectionInterface $connection
     *
     * @param Definition $definition
    */
    public function __construct(ConnectionInterface $connection, Definition $definition)
    {
        $this->connection   = $connection;
        $this->config   = $definition;
        $this->unitOfWork   = new UnitOfWork($this);
    }






    /**
     * @inheritDoc
    */
    public function open(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }






    /**
     * @inheritDoc
    */
    public function isOpen(): bool
    {
        $connected = $this->connection->connected();

        return $this->enabled;
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
    public function getUnitOfWork(): UnitOfWorkInterface
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
    public function find(string $classname, $id): object|null
    {
        return $this->getRepository($classname)->find($id);
    }






    /**
     * @inheritDoc
    */
    public function getRepository(string $classname): EntityRepositoryInterface
    {
         if (isset($this->repositories[$classname])) {
             return $this->repositories[$classname];
         }

         $factory = $this->config->getRepositoryFactory();

         if (! $repository = $factory->createRepository($classname)) {
               $repository = new EntityRepository($this, new ClassMetadata($classname));
         }

         return $this->repositories[$classname] = $repository;
    }





    /**
     * @inheritDoc
    */
    public function getMetadata(): ClassMetadataInterface
    {

    }




    /**
     * @inheritDoc
    */
    public function createQueryBuilder(): QueryBuilder
    {

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
     public function transaction(Closure $func): mixed
     {

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
    public function flush(): void
    {
        $this->unitOfWork->commit();
    }




    /**
     * @inheritDoc
    */
    public function initialize(object $object): mixed
    {

    }





    /**
     * @inheritDoc
    */
    public function contains(object $object): bool
    {

    }




    /**
     * @inheritDoc
    */
    public function persistence(array $objects): void
    {
        foreach ($objects as $object) {
            if (! is_object($object)) {
                continue;
            }
            $this->persist($object);
        }
    }





    /**
     * @inheritDoc
    */
    public function hasMapping(): bool
    {
        return ! empty($this->metadata->getClassname());
    }





    /**
     * @inheritDoc
    */
    public function getMapped(): string
    {
        return $this->metadata->getClassname();
    }





    /**
     * @return string
    */
    public function getTableName(): string
    {
        return $this->metadata->getTableName();
    }






    /**
     * @inheritDoc
    */
    public function close(): void
    {
        $this->enabled = false;
        $this->connection->disconnect();
    }
}