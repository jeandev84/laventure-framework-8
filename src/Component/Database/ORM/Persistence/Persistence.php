<?php
namespace Laventure\Component\Database\ORM\Persistence;


use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;
use Laventure\Component\Database\ORM\Persistence\Query\QueryBuilder;



/**
 * @Persistence
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence
*/
class Persistence
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
     * @var array
    */
    protected array $cache = [];





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
     * @param string|null $selects
     *
     * @return Select
    */
    public function select(string $selects = null): Select
    {
         return $this->createQueryBuilder()
                     ->select($selects)
                     ->from($this->getTableName())
                     ->map($this->getClassname());
    }







    /**
     * @param int $id
     *
     * @return mixed
    */
    public function find(int $id): mixed
    {
        if(isset($this->cache[$id])) {
             return $this->cache[$id];
        }

        return $this->cache[$id] = $this->select()
                                        ->criteria([$this->identifier() => $id])
                                        ->getQuery()
                                        ->getOneOrNullResult();
    }





    /**
     * @return int
    */
    public function insert(): int
    {
         $attributes = $this->metadata->map()->getAttributes();

         return $this->createQueryBuilder()->insert($this->getTableName(), $attributes);
    }





    /**
     * @return int
    */
    public function update(): int
    {
         $attributes = $this->metadata->map()->getAttributes();
         $criteria   = $this->criteria();

         return $this->createQueryBuilder()->update($this->getTableName(), $attributes, $criteria);
    }





    /**
     * @return bool
    */
    public function delete(): bool
    {
        return $this->createQueryBuilder()->delete($this->getTableName(), $this->criteria());
    }





    /**
     * @return ClassMetadata
    */
    public function metadata(): ClassMetadata
    {
        return $this->metadata;
    }






    /**
     * @return array
    */
    private function criteria(): array
    {
        return [$this->identifier() => $this->metadata->map()->getIdentifierValue()];
    }








    /**
     * @return QueryBuilder
    */
    private function createQueryBuilder(): QueryBuilder
    {
        return $this->em->createQueryBuilder();
    }






    /**
     * @return string
    */
    private function identifier(): string
    {
        return $this->metadata->getIdentifier();
    }






    /**
     * @return string
    */
    private function getClassname(): string
    {
        return $this->metadata->getClassname();
    }





    /**
     * @return string
    */
    private function getTableName(): string
    {
        return $this->metadata->getTableName();
    }

}