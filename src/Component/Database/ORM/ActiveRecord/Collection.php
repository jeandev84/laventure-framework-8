<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;

class Collection
{

      /**
       * @var array
      */
      protected array $items = [];





      /**
       * @param array $items
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
           return $this->items;
      }
}