<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;

use Closure;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;
use Laventure\Component\Database\ORM\Persistence\Query\QueryBuilder;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepository;
use Laventure\Component\Database\ORM\Persistence\UnitOfWork;


/**
 * @inheritdoc
*/
interface EntityManagerInterface extends ObjectManager
{


    /**
     * Determine if the entity manager opened
     *
     * @return bool
    */
    public function isOpen(): bool;








    /**
     * Returns connection real
     *
     * @return ConnectionInterface
    */
    public function getConnection(): ConnectionInterface;








    /**
     * Returns unit of work
     *
     * @return UnitOfWork
    */
    public function getUnitOfWork(): UnitOfWork;








    /**
     * Returns event manager
     *
     * @return EventManager
    */
    public function getEventManager(): EventManager;









    /**
     * Find object
     *
     * @param string $classname
     *
     * @param $id
     *
     * @return mixed
    */
    public function find(string $classname, $id): mixed;







    /**
     * @param $classname
     *
     * @return ClassMetadata
    */
    public function getClassMetadata($classname): ClassMetadata;








    /**
     * @param string $classname
     *
     * @return EntityRepository
    */
    public function getRepository(string $classname): EntityRepository;








    /**
     * Create query builder
     *
     * @return QueryBuilder
    */
    public function createQueryBuilder(): QueryBuilder;






    /**
     * Begin transaction
     *
     * @return bool
    */
    public function beginTransaction(): bool;









    /**
     * Commit all changes
     *
     * @return bool
    */
    public function commit(): bool;









    /**
     * Rollback commit process
     *
     * @return bool
    */
    public function rollback(): bool;








    /**
     * Call transaction
     *
     * @param Closure $func
     *
     * @return void
    */
    public function transaction(Closure $func): void;









    /**
     * Close entity manager
     *
     * @return void
    */
    public function close(): void;
}