<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;


/**
 * @EntityRepositoryInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence
*/
interface PersistenceInterface
{


    /**
     * @param string|null $selects
     *
     * @param array $criteria
     *
     * @return Select
    */
    public function select(string $selects = null, array $criteria = []): Select;








    /**
     * Find one record
     *
     * @param int $id
     *
     * @return object|null
    */
    public function find(int $id): ?object;






    /**
     * Insert new record
    */
    public function insert(array $attributes): int;









    /**
     * Update records
    */
    public function update(array $attributes, array $criteria): int;







    /**
     * Delete records
     *
     * @param array $criteria
     *
     * @return bool
    */
    public function delete(array $criteria): bool;
}