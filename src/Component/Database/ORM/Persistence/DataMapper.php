<?php
namespace Laventure\Component\Database\ORM\Persistence;


use Laventure\Component\Database\ORM\Persistence\Manager\EventManager;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PostPersistEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PostUpdateEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PrePersistEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PreUpdateEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\ObjectEvent;
use Laventure\Component\Database\ORM\Persistence\Mapper\Mapper;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;


/**
 * @inheritdoc
*/
class DataMapper extends Mapper
{

    /**
     * @var EntityManager
    */
    protected EntityManager $em;




    /**
     * @var object[]
    */
    protected array $data = [];




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
    public function find(int $id): ?object
    {
        return $this->data[$id] ?? null;
    }





    /**
     * @inheritDoc
    */
    public function save(object $object): int
    {
         $event  = $this->dispatchEvent(new PrePersistEvent($object));
         $object = $event->getSubject();

         if($this->mapRows($object)->isNew()) {
              return $this->insert($object);
         }

         return $this->update($object);
    }






    /**
     * @inheritDoc
    */
    public function insert(object $object): int
    {
        $id = $this->persistence($object)->insert();

        $this->dispatchEvent(new PostPersistEvent($object));

        $this->data[$id] = $object;

        return $id;
    }






    /**
     * @inheritDoc
    */
    public function update(object $object): int
    {
        $event  = $this->dispatchEvent(new PreUpdateEvent($object));
        $object = $event->getSubject();
        $id     = $this->persistence($object)->update();

        $event = $this->dispatchEvent(new PostUpdateEvent($object));
        $this->dispatchEvent(new PostPersistEvent($event->getSubject()));

        $this->data[$id] = $object;

        return $id;
    }






    /**
     * @inheritDoc
    */
    public function delete(object $object): bool
    {
        return $this->persistence($object)->delete();
    }






    /**
     * @inheritDoc
    */
    public function mapRows(object $object): ClassMetadata
    {
         return $this->metadata($object)->map();
    }






    /**
     * @param object $object
     *
     * @return ClassMetadata
    */
    private function metadata(object $object): ClassMetadata
    {
        return $this->em->getClassMetadata($object);
    }






    /**
     * @param object $object
     *
     * @return Persistence
    */
    private function persistence(object $object): Persistence
    {
         return $this->em->getUnitOfWork()->getPersistence($object);
    }






    /**
     * @return ObjectEvent
    */
    private function dispatchEvent(object $event): object
    {
        return $this->em->getUnitOfWork()
                        ->getEventManager()
                        ->dispatchEvent($event);
    }
}