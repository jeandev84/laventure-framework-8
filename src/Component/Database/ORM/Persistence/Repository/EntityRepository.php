<?php
namespace Laventure\Component\Database\ORM\Persistence\Repository;


use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\ORM\Persistence\EntityManager;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;
use Laventure\Component\Database\ORM\Persistence\Query\QueryBuilder;


/**
 * @inheritdoc
*/
class EntityRepository implements EntityRepositoryInterface
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
     * @param ClassMetadata $metadata
    */
    public function __construct(EntityManager $em, ClassMetadata $metadata)
    {
         $this->em  = $em;
         $this->metadata = $metadata;
    }





    /**
     * @param string $alias
     *
     * @return Select
    */
    public function createQueryBuilder(string $alias): Select
    {
         return $this->em->createQueryBuilder()
                         ->select()
                         ->map($this->getClassName())
                         ->from($this->getTableName(), $alias);
    }








    /**
     * @inheritDoc
    */
    public function find($id): ?object
    {
         return $this->em->find($this->getClassName(), $id);
    }





    /**
     * @inheritDoc
    */
    public function findOneBy(array $criteria, array $oderBy = []): mixed
    {
        $persistence = $this->em->getUnitOfWork()->getPersistence($this->getClassName());

        return $persistence->select()
                           ->criteria($criteria)
                           ->ordersBy($oderBy)
                           ->getQuery()
                           ->getOneOrNullResult();
    }






    /**
     * @inheritDoc
    */
    public function findAll(): array
    {
        return $this->em->getUnitOfWork()
                        ->getPersistence($this->getClassName())
                        ->select()
                        ->getQuery()
                        ->getResult();
    }





    /**
     * @inheritDoc
    */
    public function findBy(array $criteria, array $orderBy = [], int $limit = null, int $offset = null): mixed
    {
          return $this->em->getUnitOfWork()
                          ->getPersistence($this->getClassName())
                          ->select()
                          ->criteria($criteria)
                          ->ordersBy($orderBy)
                          ->limit($limit)
                          ->offset($offset)
                          ->getQuery()
                          ->getResult();

    }






    /**
     * @inheritDoc
    */
    public function getClassName(): string
    {
        return $this->metadata->getClassname();
    }






    /**
     * @return ClassMetadata
    */
    protected function getClassMetadata(): ClassMetadata
    {
        return $this->metadata;
    }





    /**
     * @return string
    */
    protected function getTableName(): string
    {
        return $this->metadata->getTableName();
    }





    /**
     * @return EntityManager
    */
    protected function getEntityManager(): EntityManager
    {
        return $this->em;
    }
}