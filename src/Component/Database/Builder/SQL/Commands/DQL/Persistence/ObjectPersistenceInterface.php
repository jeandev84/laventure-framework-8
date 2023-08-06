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
     * Determine if mapped class
     *
     * @return bool
    */
    public function hasMapping(): bool;





    /**
     * Returns mapped class
     *
     * @return string
    */
    public function getMapped(): string;






    /**
     * @param object[] $objects
     *
     * @return void
    */
    public function persistence(array $objects): void;
}