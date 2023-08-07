<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Laventure\Component\Database\ORM\Collection\ArrayCollection;
use Laventure\Component\Database\ORM\Collection\Collection;
use Laventure\Component\Database\ORM\Collection\ObjectStorage;


/**
 *
*/
class PersistenceCollection extends ObjectStorage
{

     /**
      * @var ArrayCollection[]
     */
     protected array $collections = [];




     /**
      * @param string $column
      *
      * @param Collection $collection
      *
      * @return $this
     */
     public function addCollection(string $column, Collection $collection): static
     {
          $this->collections[$column] = $collection;

          return $this;
     }





     /**
      * @return array
     */
     public function getCollections(): array
     {
          return $this->collections;
     }






     /**
      * @param EntityManager $em
      *
      * @return bool
     */
     public function save(EntityManager $em): bool
     {
           return true;
     }
}