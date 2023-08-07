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
        return $this->persistence($object)->insert();
    }






    /**
     * @inheritDoc
    */
    public function update(object $object): int
    {
        $id = $this->persistence($object)->update();
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
}