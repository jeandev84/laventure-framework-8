<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence;



/**
 * @inheritdoc
*/
class ObjectPersistence implements ObjectPersistenceInterface
{


     /**
      * @var string
     */
     protected string $classname = '';



     /**
      * @var array
     */
     protected array $persisted = [];





     /**
      * @param string $classname
      *
      * @return static
     */
     public function mapped(string $classname): static
     {
         $this->classname = $classname;

         return $this;
     }





     /**
      * @inheritDoc
     */
     public function persistence(array $objects): void
     {
           $this->persisted[] = $objects;
     }





     /**
      * @inheritDoc
     */
     public function hasMapping(): bool
     {
         return ! empty($this->classname);
     }




     /**
      * @inheritDoc
     */
     public function getMapped(): string
     {
         return $this->classname;
     }
}