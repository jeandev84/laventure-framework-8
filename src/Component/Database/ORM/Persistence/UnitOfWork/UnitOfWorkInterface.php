<?php
namespace Laventure\Component\Database\ORM\Persistence\UnitOfWork;


/**
 * @UnitOfWorkInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\UnitOfWork
*/
interface UnitOfWorkInterface
{


     /**
      * Register state NEW or UPDATE
      *
      * @param object $object
      *
      * @return void
     */
     public function persist(object $object): void;








     /**
      * Register state REMOVED
      *
      * @param object $object
      *
      * @return void
     */
     public function remove(object $object): void;







     /**
      * @param object $object
      *
      * @return void
     */
     public function refresh(object $object): void;








     /**
      * @param object $object
      *
      * @return void
     */
     public function attach(object $object): void;







     /**
      * @param object $object
      *
      * @return void
     */
     public function detach(object $object): void;






     /**
      * @param object $object
      *
      * @return void
     */
     public function merge(object $object): void;






     /**
      * Commit changes
      *
      * @return bool
     */
     public function commit(): bool;








     /**
      * @return void
     */
     public function clear(): void;
}