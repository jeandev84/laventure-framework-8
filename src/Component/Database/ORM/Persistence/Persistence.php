<?php
namespace Laventure\Component\Database\ORM\Persistence;


use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;
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
     * @var ClassMetadata
    */
    protected ClassMetadata $metadata;





    /**
     * @param EntityManager $em
     *
     * @param string $classname
    */
    public function __construct(EntityManager $em, string $classname)
    {
         $this->em        = $em;
         $this->metadata  = $this->em->getClassMetadata($classname);
    }






    /**
     * @return QueryBuilder
    */
    public function createQueryBuilder(): QueryBuilder
    {
        return $this->em->createQueryBuilder();
    }





    /**
     * @return string
    */
    public function getIdentifier(): string
    {
        return $this->metadata->getIdentifier();
    }





    /**
     * @return string
    */
    public function getClassname(): string
    {
        return $this->metadata->getClassname();
    }





    /**
     * @return string
    */
    public function getTableName(): string
    {
        return $this->metadata->getTableName();
    }







    /**
     * @inheritDoc
    */
    public function select(string $selects = null, array $criteria = []): Select
    {
         return $this->createQueryBuilder()
                     ->select($selects)
                     ->from($this->getTableName())
                     ->criteria($criteria)
                     ->map($this->getClassname());
    }






    /**
     * @inheritdoc
    */
    public function find(int $id): ?object
    {
        return $this->select("*", [$this->getIdentifier() => $id]);
    }





    /**
     * @inheritDoc
    */
    public function insert(array $attributes): int
    {
         return $this->createQueryBuilder()->insert($this->getTableName(), $attributes);
    }






    /**
     * @inheritDoc
    */
    public function update(array $attributes, array $criteria): int
    {
         return $this->createQueryBuilder()->update($this->getTableName(), $attributes, $criteria);
    }






    /**
     * @inheritDoc
    */
    public function delete(array $criteria): bool
    {
        return $this->createQueryBuilder()->delete($this->getTableName(), $criteria);
    }
}