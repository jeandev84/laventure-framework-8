<?php
namespace Laventure\Component\Database\Builder\SQL;


use Laventure\Component\Database\Builder\SQL\Commands\DML\Delete;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Insert;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Update;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;

/**
 * @SqlQueryBuilder
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL
*/
interface SqlQueryBuilderInterface
{



     /**
      * Select records
      *
      * @param string|null $selects
      * @return Select
     */
     public function select(string $selects = null): Select;









     /**
      * Insert records
      *
      * @param string $table
      *
      * @param array $attributes
      *
      * @return Insert
     */
     public function insert(string $table, array $attributes): Insert;








     /**
      * Update record
      *
      * @param string $table
      *
      * @param array $attributes
      *
      * @param array $criteria
      *
      * @return Update
     */
     public function update(string $table, array $attributes, array $criteria): Update;











     /**
      * @param string $table
      *
      * @param array $criteria
      *
      * @return Delete
     */
     public function delete(string $table, array $criteria): Delete;
}