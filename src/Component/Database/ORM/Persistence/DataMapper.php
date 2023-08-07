<?php
namespace Laventure\Component\Database\ORM\Persistence;

use DateTimeInterface;
use Laventure\Component\Database\ORM\Collection\Collection;
use Laventure\Component\Database\ORM\Persistence\Mapper\DataMapperInterface;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;


/**
 * @inheritdoc
*/
class DataMapper implements DataMapperInterface
{

    use EntityPropertyResolver;

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
    public function find($id): ?object
    {

    }





    /**
     * @inheritDoc
    */
    public function save(object $object): int
    {

    }




    /**
     * @inheritDoc
    */
    public function delete(object $object): int
    {

    }







    /**
     * @inheritDoc
    */
    public function mapRows(object $object): ClassMetadata
    {
         return $this->em->getClassMetadata($object)->map();
    }
}