<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;


/**
 * @EventManagerInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\Manager
*/
interface EventManagerInterface
{

      /**
       * @param string $event
       *
       * @param object $object
       *
       * @return mixed
     */
     public function prePersist(string $event, object $object): mixed;






     /**
      * @param string $event
      *
      * @param object $object
      *
     * @return mixed
     */
     public function preRemove(string $event, object $object): mixed;






     /**
      * @param string $event
      *
      * @param object $object
      *
      * @return mixed
     */
     public function preUpdate(string $event, object $object): mixed;








     /**
      * @param string $event
      *
      * @param object $object
      *
      * @return mixed
     */
     public function preFlush(string $event, object $object): mixed;









     /**
      * @param string $event
      *
      * @return mixed
     */
     public function dispatch(string $event): mixed;
}