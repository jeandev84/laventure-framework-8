<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;

class Collection
{

      /**
       * @var array
      */
      protected array $items = [];





      /**
       * @param object[] $items
      */
      public function __construct(array $items)
      {
           $this->items = $items;
      }





      /**
       * @return false|string
      */
      public function toJson(): bool|string
      {
          return json_encode($this->items);
      }





      /**
       * @return array
      */
      public function toArray(): array
      {
           return json_decode($this->toJson(), true);
      }





     /**
      * @return array
     */
     public function getItems(): array
     {
        return $this->items;
     }
}