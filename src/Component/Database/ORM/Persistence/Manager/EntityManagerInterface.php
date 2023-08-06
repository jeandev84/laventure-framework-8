<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;

use Closure;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadataInterface;
use Laventure\Component\Database\ORM\Persistence\Query\QueryBuilder;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepositoryInterface;
use Laventure\Component\Database\ORM\Persistence\UnitOfWork\UnitOfWorkInterface;


/**
 * @inheritdoc
*/
interface EntityManagerInterface extends ObjectManager
{


    /**
     * Open entity manager
     *
     * @param bool $enabled
     *
     * @return static
    */
    public function open(bool $enabled): static;







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
     * @return UnitOfWorkInterface
    */
    public function getUnitOfWork(): UnitOfWorkInterface;








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
     * @return object|null
    */
    public function find(string $classname, $id): object|null;








    /**
     * @param string $classname
     *
     * @return EntityRepositoryInterface
    */
    public function getRepository(string $classname): EntityRepositoryInterface;







    /**
     * Returns
     *
     * @return ClassMetadataInterface
    */
    public function getMetadata(): ClassMetadataInterface;






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