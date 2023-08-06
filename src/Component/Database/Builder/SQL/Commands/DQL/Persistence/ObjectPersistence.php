<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;

use Laventure\Component\Database\Builder\SQL\Commands\DQL\Mapping\ObjectPersistenceInterface;

class ObjectPersistence implements ObjectPersistenceInterface
{


     /**
      * @var string
     */
     protected string $classname = '';



     /**
      * @var bool
     */
     protected bool $enabled = false;




     /**
      * @var array
     */
     protected array $persisted = [];




     /**
      * @inheritDoc
     */
     public function open(bool $enabled): static
     {
          $this->enabled = $enabled;

          return $this;
     }





     /**
      * @inheritDoc
     */
     public function isOpen(): bool
     {
         return $this->enabled;
     }




     /**
      * @inheritDoc
     */
     public function persistence(array $objects): static
     {
           if ($this->isOpen()) {
               $this->persisted[] = $objects;
           }

           return $this;
     }





    /**
     * @inheritDoc
    */
    public function mapped(string $classname): static
    {
        $this->classname = $classname;

        return $this;
    }




    /**
     * @inheritDoc
    */
    public function getMapped(): string
    {
        return $this->classname;
    }



    /**
     * @inheritDoc
    */
    public function close(): void
    {
         $this->enabled = false;
         $this->persisted = [];
    }
}