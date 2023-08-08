<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


/**
 * @Persistence
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence
 */
interface ActiveRecordInterface
{


      /**
       * Returns one record by identifier given value
       *
       * @param int $id
       *
       * @return mixed
      */
      public static function find(int $id): mixed;













      /**
       * Returns all records
       *
       * @return array
      */
      public static function findAll(): array;









      /**
       *
       * @return bool
      */
      public function delete(): bool;












      /**
       * Update or Delete object
       *
       * @return int
      */
      public function save(): int;
}