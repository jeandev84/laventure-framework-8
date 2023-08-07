<?php
namespace Laventure\Component\Database\ORM\Persistence;


use Laventure\Component\Database\ORM\Collection\ObjectStorage;
use Laventure\Component\Database\ORM\Persistence\Manager\Exception\EntityManagerException;
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
     * @var EntityManager
    */
    protected EntityManager $em;




    /**
     * @var ObjectStorage
    */
    protected ObjectStorage $storage;





    /**
     * @var DataMapper
    */
    protected DataMapper $dataMapper;





    /**
     * @var object[]
    */
    protected array $managed = [];




    /**
     * @var object[]
    */
    protected array $persists = [];




    /**
     * @var object[]
    */
    protected array $removes = [];





    /**
     * @param EntityManager $em
    */
    public function __construct(EntityManager $em)
    {
         $this->em         = $em;
         $this->dataMapper = new DataMapper($this->em);
         $this->storage    = new ObjectStorage();
    }








    /**
     * @param string|object $context
     *
     * @return Persistence
    */
    public function getPersistence(string|object $context): Persistence
    {
         return new Persistence($this->em, $context);
    }






    /**
     * @inheritDoc
    */
    public function persist(object $object): void
    {
        $this->persists[] = $object;
    }






    /**
     * @inheritDoc
    */
    public function remove(object $object): void
    {
        $this->removes[] = $object;
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
        $this->storage->attach($object);
    }





    /**
     * @inheritDoc
    */
    public function detach(object $object): void
    {
        $this->storage->detach($object);
    }





    /**
     * @inheritDoc
    */
    public function merge(object $object): void
    {
         $this->attach($object);
    }





    /**
     * @inheritDoc
    */
    public function commit(): void
    {
         $this->em->transaction(function () {

         });
    }






    /**
     * @inheritdoc
    */
    public function getPersists(): array
    {
        return $this->persists;
    }






    /**
     * @inheritdoc
    */
    public function getRemoves(): array
    {
        return $this->removes;
    }






    /**
     * @inheritDoc
    */
    public function clear(): void
    {
        $this->storage->clear();
    }
}