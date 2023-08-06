<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;

use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepositoryInterface;


/**
 * @inheritdoc
*/
interface EntityManagerInterface extends ObjectManager
{


    /**
     * @param bool $enabled
     *
     * @return mixed
    */
    public function open(bool $enabled): mixed;






    /**
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
     * @param string $classname
     *
     * @return mixed
    */
    public function getClassMetadata(string $classname);








    /**
     * @return void
    */
    public function close(): void;
}