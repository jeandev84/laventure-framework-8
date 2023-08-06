<?php
namespace Laventure\Component\Database\ORM\Persistence\Repository;

class RepositoryFactory extends EntityRepositoryFactory
{

    /**
     * @inheritDoc
    */
    public function createRepository(string $classname): ?EntityRepository
    {
         return null;
    }
}