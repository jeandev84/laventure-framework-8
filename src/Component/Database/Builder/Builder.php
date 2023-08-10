<?php
namespace Laventure\Component\Database\Builder;



use Laventure\Component\Database\Builder\SQL\Commands\DQL\Mapping\ObjectPersistenceInterface;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\Builder\SQL\Commands\Expr\Expr;
use Laventure\Component\Database\Builder\SQL\SqlQueryBuilder;
use Laventure\Component\Database\Connection\ConnectionInterface;


/**
 * @Builder
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder
*/
class Builder
{

      /**
       * @var SqlQueryBuilder
      */
      protected SqlQueryBuilder $builder;





     /**
      * @param ConnectionInterface $connection
     */
     public function __construct(ConnectionInterface $connection)
     {
          $this->builder = new SqlQueryBuilder($connection);
     }






     /**
      * Expression builder
      *
      * @return Expr
     */
     public function expr(): Expr
     {
         return new Expr();
     }






    /**
     * Select records
     *
     * @param string|null $selects
     *
     * @param bool $distinct
     *
     * @return Select
    */
    public function select(string $selects = null, bool $distinct = false): Select
    {
         return $this->builder->select($selects)->distinct($distinct);
    }





    /**
     * Insert records
     *
     * @param string $table
     *
     * @param array $attributes
     *
     * @return int
    */
    public function insert(string $table, array $attributes): int
    {
         return $this->builder->insert($table, $attributes)->execute();
    }










    /**
     * Update record
     *
     * @param string $table
     *
     * @param array $attributes
     *
     * @param array $criteria
     *
     * @return int
    */
    public function update(string $table, array $attributes, array $criteria): int
    {
         return $this->builder->update($table, $attributes, $criteria)->execute();
    }









    /**
     * @param string $table
     *
     * @param array $criteria
     *
     * @return bool
    */
    public function delete(string $table, array $criteria): bool
    {
         return $this->builder->delete($table, $criteria)->execute();
    }
}