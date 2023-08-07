<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Laventure\Component\Database\ORM\Persistence\Mapper\DataMapperInterface;
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
    public function find($id): ?object
    {
        return $this->data[$id] ?? null;
    }





    /**
     * @inheritDoc
    */
    public function save(object $object): int
    {
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
        $attributes =  $this->mapRows($object)->getAttributes();

        return $this->persistence($object)->insert($attributes);
    }






    /**
     * @inheritDoc
    */
    public function update(object $object): int
    {
        $rows            =  $this->mapRows($object);
        $persistence     =  $this->persistence($object);
        $criteria        =  [$this->metadata($object)->getIdentifier() => $rows->getIdentifierValue()];
        $id              =  $persistence->update($rows->getAttributes(), $criteria);
        $this->data[$id] = $object;
        return $id;
    }






    /**
     * @inheritDoc
    */
    public function delete(object $object): bool
    {
        $rows     =  $this->mapRows($object);
        $criteria =  [$this->metadata($object)->getIdentifier() => $rows->getIdentifierValue()];

        return $this->persistence($object)->delete($criteria);
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
          return $this->em->getUnitOfWork()->getPersistence(get_class($object));
    }
}