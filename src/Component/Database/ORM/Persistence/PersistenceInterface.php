<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;


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
    public function insert(): int;









    /**
     * Update records
    */
    public function update(): int;







    /**
     * Delete records
     *
     * @return bool
    */
    public function delete(): bool;









    /**
     * @return ClassMetadata
    */
    public function metadata(): ClassMetadata;
}