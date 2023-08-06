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
interface EntityRepositoryFactory
{

    /**
     * Create repository
     *
     * @param string $classname
     *
     * @return EntityRepositoryInterface|null
    */
    public function createRepository(string $classname): ?EntityRepositoryInterface;
}