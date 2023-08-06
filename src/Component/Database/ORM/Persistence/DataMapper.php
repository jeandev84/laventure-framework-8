<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Laventure\Component\Database\ORM\Persistence\Mapper\Mapper;



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
    protected function mapRows(object $object)
    {

    }
}