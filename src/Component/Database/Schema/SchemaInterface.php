<?php
namespace Laventure\Component\Database\Schema;


use Closure;
use Laventure\Component\Database\Connection\Query\QueryInterface;

/**
 * @SchemaInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Schema
*/
interface SchemaInterface
{

     /**
      * Create schema
      *
      * @param string $table
      *
      * @param Closure $closure
      *
      * @return mixed
     */
     public function create(string $table, Closure $closure): mixed;






     /**
      * Update schema
      *
      * @param string $table
      *
      * @param Closure $closure
      *
      * @return mixed
     */
     public function update(string $table, Closure $closure): mixed;






     /**
      * Drop schema
      *
      * @param string $table
      *
      * @return mixed
     */
     public function drop(string $table): mixed;






     /**
      * Drop schema if exists
      *
      * @param string $table
      *
      * @return mixed
     */
     public function dropIfExists(string $table): mixed;





     /**
      * Truncate table
      *
      * @param string $table
      *
      * @return mixed
     */
     public function truncate(string $table): mixed;






     /**
      * Truncate table cascade
      *
      * @param string $table
      *
      * @return mixed
     */
     public function truncateCascade(string $table): mixed;








     /**
      * Returns table columns
      *
      * @param string $table
      *
      * @return array
     */
     public function getColumns(string $table): array;







     /**
      * Determine if schema exists
      *
      * @param string $table
      *
      * @return bool
     */
     public function exists(string $table): bool;








     /**
      * Determine if columns exists in given table
      *
      * @param string $table
      *
      * @param string $column
      *
      * @return bool
     */
     public function hasColumn(string $table, string $column): bool;





     /**
      * @param string $sql
      *
      * @param array $params
      *
      * @return QueryInterface
     */
     public function statement(string $sql, array $params = []): QueryInterface;








     /**
      * @param string $sql
      *
      * @return bool
     */
     public function exec(string $sql): bool;










     /**
      * Return database tables
      *
      * @return array
     */
     public function getTables(): array;

}