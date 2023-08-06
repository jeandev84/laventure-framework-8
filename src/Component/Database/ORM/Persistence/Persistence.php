<?php
namespace Laventure\Component\Database\ORM\Persistence;


use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\ORM\Persistence\Query\QueryBuilder;


/**
 * @implements
*/
class Persistence implements PersistenceInterface
{


    /**
     * @var EntityManager
    */
    protected EntityManager $em;



    /**
     * @var string
    */
    protected string $classname;




    /**
     * @param EntityManager $em
     *
     * @param string $classname
    */
    public function __construct(EntityManager $em, string $classname)
    {
         $this->em        = $em;
         $this->classname = $classname;
    }





    /**
     * @inheritDoc
    */
    public function select(string $selects = null, array $criteria = []): Select
    {
         $qb = $this->em->createQueryBuilder()->select($selects);
         return $qb->map($this->classname)
                   ->criteria($criteria);
    }




    /**
     * @inheritDoc
    */
    public function insert(string $table, array $attributes): int
    {
         return $this->em->createQueryBuilder()->insert($table, $attributes);
    }




    /**
     * @inheritDoc
    */
    public function update(string $table, array $attributes, array $criteria): int
    {
         return $this->em->createQueryBuilder()->update($table, $attributes, $criteria);
    }






    /**
     * @inheritDoc
    */
    public function delete(string $table, array $criteria): bool
    {
        return $this->em->createQueryBuilder()->delete($table, $criteria);
    }
}