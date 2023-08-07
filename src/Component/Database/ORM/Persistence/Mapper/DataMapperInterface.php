<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapper;

/**
 * @DataMapperInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\Mapper
*/
interface DataMapperInterface
{

    /**
     * @param int $id
     *
     * @return object|null
    */
    public function find(int $id): ?object;






    /**
     * @param object $object
     *
     * @return int
    */
    public function save(object $object): int;






    /**
     * @param object $object
     *
     * @return bool
    */
    public function delete(object $object): bool;






    /**
     * @param object $object
     *
     * @return mixed
    */
    public function mapRows(object $object): mixed;
}