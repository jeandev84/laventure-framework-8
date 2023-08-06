<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\ORM\Persistence\UnitOfWork\UnitOfWorkInterface;


/**
 * @inheritdoc
*/
class UnitOfWork implements UnitOfWorkInterface
{

    const STATE_MANAGED   = 1;
    const STATE_NEW       = 2;
    const STATE_DETACHED  = 3;
    const STATE_REMOVED   = 4;





    /**
     * @var Persistence
    */
    protected Persistence $persistence;




    /**
     * @var array
    */
    protected array $managed = [];





    /**
     * @var object[]
    */
    protected array $persisted = [];





    /**
     * @var object[]
    */
    protected array $removes = [];




    /**
     * @var EntityManager
    */
    protected EntityManager $em;






    /**
     * @param EntityManager $em
    */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }





    /**
     * @param string $classname
     *
     * @return Persistence
    */
    public function getPersistence(string $classname): Persistence
    {
         return new Persistence($this->em, $classname);
    }







    /**
     * @inheritDoc
    */
    public function persist(object $object): void
    {

    }





    /**
     * @inheritDoc
    */
    public function remove(object $object): void
    {

    }





    /**
     * @inheritDoc
    */
    public function refresh(object $object): void
    {

    }




    /**
     * @inheritDoc
    */
    public function attach(object $object): void
    {

    }





    /**
     * @inheritDoc
    */
    public function detach(object $object): void
    {

    }




    /**
     * @inheritDoc
    */
    public function merge(object $object): void
    {

    }




    /**
     * @inheritDoc
    */
    public function commit(): bool
    {

    }





    /**
     * @inheritDoc
    */
    public function clear(): void
    {

    }
}