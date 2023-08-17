<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


/**
 * @ActiveRecordInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\ActiveRecord
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
      public static function all(): array;










      /**
       *
       * @return bool
      */
      public function delete(): bool;












      /**
       * Update or Insert records
       *
       * @return int
      */
      public function save(): int;







      /**
       * Get all attributes
       *
       * @return array
      */
      public function getAttributes(): array;
}