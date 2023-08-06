<?php
namespace Laventure\Component\Database\ORM\Persistence\Repository;

/**
 * @EntityRepositoryFactory
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\Repository
*/
abstract class EntityRepositoryFactory
{

    /**
     * Create repository
     *
     * @param string $classname
     *
     * @return EntityRepository|null
    */
    abstract public function createRepository(string $classname): ?EntityRepository;
}