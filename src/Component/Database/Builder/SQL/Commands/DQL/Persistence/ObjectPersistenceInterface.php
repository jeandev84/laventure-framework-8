<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL\Mapping;


/**
 * @ObjectPersistenceInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence
*/
interface ObjectPersistenceInterface
{


     /**
      * @return bool
     */
     public function isOpen(): bool;




     /**
      * @param bool $enabled
      *
      * @return mixed
     */
     public function open(bool $enabled): mixed;





     /**
      * @param string $classname
      *
      * @return static
     */
     public function mapped(string $classname): static;






     /**
      * @param object[] $objects
      *
      * @return mixed
     */
     public function persistence(array $objects): mixed;







     /**
      * @return string
     */
     public function getMapped(): string;






     /**
      * @return void
     */
     public function close(): void;
}