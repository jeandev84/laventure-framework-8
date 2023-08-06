<?php
namespace Laventure\Component\Database\ORM\Persistence;

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
     * @var array
    */
    protected array $persisted = [];






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
     * @inheritDoc
    */
    public function find($id): void
    {

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