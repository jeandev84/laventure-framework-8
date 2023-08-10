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
interface ActiveRecordInterface extends \ArrayAccess
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
       * Update or Delete object
       *
       * @return int
      */
      public function save(): int;
}