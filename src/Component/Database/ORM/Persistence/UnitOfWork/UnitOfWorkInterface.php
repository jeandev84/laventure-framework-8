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


     const STATE_MANAGED   = 1;
     const STATE_NEW       = 2;
     const STATE_DETACHED  = 3;
     const STATE_REMOVED   = 4;



     /**
      * Find storage object
      *
      * @param int $id
      *
      * @return object|null
     */
     public function find(int $id): ?object;






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
      * @param object $object
      *
      * @return bool
     */
     public function contains(object $object): bool;





     /**
      * Commit changes
      *
      * @return void
     */
     public function commit(): void;






     /**
      * @param object $object
      *
      * @return void
     */
     public function addPersistState(object $object): void;








     /**
      * Add removed state
      *
      * @param object $object
      *
      * @return void
     */
     public function addRemovedState(object $object): void;








     /**
      * Add detached state
      *
      * @param object $object
      * @return void
     */
     public function addDetachedState(object $object): void;










     /**
      * @return void
     */
     public function clear(): void;
}