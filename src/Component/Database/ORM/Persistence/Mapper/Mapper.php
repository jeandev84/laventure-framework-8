<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapper;


/**
 * @inheritdoc
*/
abstract class Mapper implements DataMapperInterface
{
      /**
       * Insert object
       *
       * @param object $object
       *
       * @return int
      */
      abstract public function insert(object $object): int;




     /**
      * Update object
      *
      * @param object $object
      *
      * @return int
     */
     abstract public function update(object $object): int;
}