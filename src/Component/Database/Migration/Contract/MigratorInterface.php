<?php
namespace Laventure\Component\Database\Migration\Contract;


/**
 * @Migration
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Migration\Contract
*/
interface MigratorInterface
{

      /**
       * Create a migration version table
       *
       * @return mixed
      */
      public function install(): mixed;







      /**
       * Migrate all migrations
       *
       * @return mixed
      */
      public function migrate(): mixed;







     /**
      * Drop all schema tables
      *
      * @return mixed
     */
     public function rollback(): mixed;







     /**
      * Drop all schema tables and version table.
      *
      * @return mixed
     */
     public function reset(): mixed;







     /**
      * Refresh migrations
      *
      * @return mixed
     */
     public function refresh(): mixed;







    /**
     * Get all migrations
     *
     * @return array
    */
    public function getMigrations(): array;







    /**
     * Get migrations to apply
     *
     * @return array
    */
    public function getMigrationsToApply(): array;








    /**
     * Get applied migrations
     *
     * @return array
    */
    public function getAppliedMigrations(): array;







    /**
     * Returns version table
     *
     * @return string
    */
    public function getTable(): string;

}