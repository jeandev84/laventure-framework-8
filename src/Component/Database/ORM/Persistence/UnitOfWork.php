<?php
namespace Laventure\Component\Database\ORM\Persistence;


use Laventure\Component\Database\ORM\Collection\ObjectStorage;
use Laventure\Component\Database\ORM\Persistence\Manager\Event\EventManager;
use Laventure\Component\Database\ORM\Persistence\UnitOfWork\UnitOfWorkInterface;


/**
 * @inheritdoc
*/
class UnitOfWork implements UnitOfWorkInterface
{


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
     * @var EventManager
    */
    protected EventManager $eventManager;





    /**
     * @var object[]
    */
    protected array $managed = [];




    /**
     * @var array
    */
    protected array $persisted = [];




    /**
     * @var object[]
    */
    protected array $persists = [];




    /**
     * @var object[]
    */
    protected array $removes = [];





    /**
     * @var array
    */
    protected array $removed = [];





    /**
     * @param EntityManager $em
    */
    public function __construct(EntityManager $em)
    {
         $this->em           = $em;
         $this->eventManager = $em->getEventManager();
         $this->dataMapper   = new DataMapper($this->em);
         $this->storage      = new ObjectStorage();
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

        $this->attach($object);
    }






    /**
     * @inheritDoc
    */
    public function remove(object $object): void
    {
        $this->removes[] = $object;

        $this->detach($object);
    }






    /**
     * @inheritDoc
    */
    public function find(int $id): ?object
    {
        return $this->dataMapper->find($id);
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
             $this->save();
             $this->delete();
         });
    }






    /**
     * @return void
    */
    private function save(): void
    {
        foreach ($this->persists as $object) {
            if ($this->storage->contains($object)) {
                if($this->dataMapper->save($object)) {
                    $this->persisted[] = $object;
                }
            }
        }
    }






    /**
     * @return void
    */
    private function delete(): void
    {
        foreach($this->removes as $object) {
            if($this->dataMapper->delete($object)) {
                $this->removed[] = $object;
            }
        }
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