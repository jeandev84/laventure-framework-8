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
     * @param $classname
    */
    public function __construct(EntityManager $em, $classname)
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
        return $this->select("*", [$this->getIdentifier() => $id])
                    ->getQuery()
                    ->getOneOrNullResult();
    }





    /**
     * @inheritDoc
    */
    public function insert(): int
    {
         $attributes = $this->metadata->map()->getAttributes();

         return $this->createQueryBuilder()->insert($this->getTableName(), $attributes);
    }






    /**
     * @inheritDoc
    */
    public function update(): int
    {
         $attributes = $this->metadata->map()->getAttributes();
         $criteria   = $this->criteria();

         return $this->createQueryBuilder()->update($this->getTableName(), $attributes, $criteria);
    }







    /**
     * @inheritDoc
    */
    public function delete(): bool
    {
        return $this->createQueryBuilder()->delete($this->getTableName(), $this->criteria());
    }







    /**
     * @inheritDoc
    */
    public function metadata(): ClassMetadata
    {
        return $this->metadata;
    }







    /**
     * @return array
    */
    public function criteria(): array
    {
        return [$this->getIdentifier() => $this->metadata->map()->getIdentifierValue()];
    }
}