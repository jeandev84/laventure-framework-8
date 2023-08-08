<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence;


/**
 * @ObjectPersistenceInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence
*/
interface ObjectPersistenceInterface
{

    /**
     * @param object[] $objects
     *
     * @return mixed
    */
    public function persistence(array $objects): mixed;
}