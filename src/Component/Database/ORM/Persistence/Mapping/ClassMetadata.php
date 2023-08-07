<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapping;


use DateTimeInterface;
use Laventure\Component\Database\ORM\Collection\Collection;
use Laventure\Component\Database\ORM\Persistence\PersistenceCollection;
use ReflectionClass;


/**
 * @inheritdoc
*/
class ClassMetadata implements ClassMetadataInterface
{

        /**
        * @var ReflectionClass
        */
        protected ReflectionClass $reflection;



        /**
        * @var string
        */
        protected string $classname;




        /**
         * @var string
        */
        protected string $table;





        /**
         * @var string
        */
        protected string $identifier = 'id';







       /**
        * @param string|object $classname
        *
        * @param string|null $table
       */
       public function __construct(string|object $classname, string $table = null)
       {
           try {

               $reflection        =  new ReflectionClass($classname);
               $shortName         =  $reflection->getShortName();
               $this->table       = $table ?: mb_strtolower("{$shortName}s");
               $this->reflection  = $reflection;

           } catch (\Exception $e) {
                trigger_error($e->getMessage());
           }
       }






       /**
        * @inheritDoc
       */
       public function getClassname(): string
       {
           return $this->reflection->getName();
       }






       /**
        * @inheritDoc
       */
       public function getTableName(): string
       {
           return $this->table;
       }





       /**
        * @inheritdoc
       */
       public function getReflection(): ReflectionClass
       {
           return $this->reflection;
       }




      /**
       * @inheritDoc
      */
      public function getIdentifier(): string
      {
           return $this->identifier;
      }





      /**
       * @inheritDoc
      */
      public function isIdentifier(string $field): bool
      {
          if (! $this->hasField($field)) {
               return false;
          }

          return $this->getIdentifier() === $field;
      }






      /**
       * @inheritDoc
      */
      public function getFieldNames(): array
      {
          $columns = [];

          foreach ($this->reflection->getProperties() as $property) {
              $columns[] = $property->getName();
          }

          return $columns;
      }





      /**
       * @inheritDoc
      */
      public function hasField(string $field): bool
      {
           return in_array($field, $this->getFieldNames());
      }





      /**
       * @inheritDoc
      */
      public function hasAssociation(string $field): bool
      {
           if (! $this->hasField($field)) {
               return false;
           }

           dd($this->getReflection());
      }






     /**
      * @inheritDoc
     */
     public function isSingleValueAssociation(string $field): bool
     {

     }




     /**
      * @inheritDoc
     */
     public function isCollectionValueAssociation(string $field): bool
     {
          if (! $this->hasField($field)) {
              return false;
          }
     }





    /**
     * @inheritDoc
    */
    public function getIdentifierValues(object $object): mixed
    {

    }
}