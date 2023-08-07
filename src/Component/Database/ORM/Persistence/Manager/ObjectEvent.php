<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;


/**
 * @ObjectEvent
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\Manager
*/
abstract class ObjectEvent
{
      public function __construct(protected object $object)
      {

      }



      /**
       * @return object
      */
      public function getSubject(): object
      {
           return $this->object;
      }
}