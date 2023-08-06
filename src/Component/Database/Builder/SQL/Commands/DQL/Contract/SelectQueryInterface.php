<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract;


/**
 * @SelectQueryInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract
*/
interface SelectQueryInterface
{

    /**
     * Return the name of mapped class
     *
     * @return string
    */
    public function getMappedClass(): string;






    /**
     * Returns all results
     *
     * @return array
    */
    public function getResult(): array;







    /**
     * Returns one or null result
     *
     * @return object|mixed|null
    */
    public function getOneOrNullResult(): mixed;







    /**
     * Returns result as associative array
     *
     * @return array
    */
    public function getArrayResult(): array;







    /**
     * Returns columns as associative
     *
     * @return array
    */
    public function getArrayColumns(): array;
}