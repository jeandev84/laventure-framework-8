<?php
namespace Laventure\Component\Database\ORM\Persistence;

use Laventure\Component\Database\ORM\Collection\ArrayCollection;
use Laventure\Component\Database\ORM\Collection\Collection;
use Laventure\Component\Database\ORM\Collection\ObjectStorage;


/**
 * @PersistenceCollection
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence
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
      * @param string $column
      *
      * @return bool
     */
     public function hasCollection(string $column): bool
     {
         return array_key_exists($column, $this->collections);
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