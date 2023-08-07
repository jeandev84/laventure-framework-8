<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapping;


use DateTimeInterface;
use Laventure\Component\Database\ORM\Collection\Collection;
use Laventure\Component\Database\ORM\Persistence\EntityPropertyResolver;
use Laventure\Component\Database\ORM\Persistence\PersistenceCollection;
use ReflectionClass;
use ReflectionObject;


/**
 * @inheritdoc
*/
class ClassMetadata implements ClassMetadataInterface
{


        use EntityPropertyResolver;




        /**
        * @var ReflectionClass
        */
        protected ReflectionClass $reflection;



        /**
        * @var string|object
        */
        protected string|object $context;




        /**
         * @var string
        */
        protected string $table;




        /**
         * @var PersistenceCollection
        */
        protected PersistenceCollection $collection;




        /**
         * @var string
        */
        protected string $identifier = 'id';




        /**
         * @var array
        */
        protected array $identifiers = [];





        /**
         * @var array
        */
        protected array $properties = [];




        /**
         * @var array
         */
        protected array $attributes = [];




        /**
         * @var object[]
         */
        protected array $belongs  = [];




        /**
         * @var array
        */
        protected array $methods  = [];




       /**
        * @param string|object $context
        *
        * @param string $table
       */
       public function __construct(string|object $context, string $table = '')
       {
           $this->context    = $context;
           $this->table      = $table;
           $this->collection = new PersistenceCollection();
       }





       /**
        * @return object
       */
       public function getObject(): object
       {
           if (! is_object($this->context)) {
               trigger_error("Required object context for mapping.");
           }

           return $this->context;
       }




       /**
        * @inheritDoc
       */
       public function getClassname(): string
       {
           return $this->getReflection()->getName();
       }






       /**
        * @inheritDoc
       */
       public function getTableName(): string
       {
           $reflection  = $this->getReflection();
           $shortName   =  $reflection->getShortName();
           return $this->table ?: mb_strtolower("{$shortName}s");
       }





       /**
        * @inheritdoc
       */
       public function getReflection(): ReflectionObject|ReflectionClass
       {
           return $this->createReflection($this->context);
       }






       /**
        * @param string|object $context
        *
        * @return ReflectionClass|ReflectionObject
        *
        * @throws \ReflectionException
       */
       private function createReflection(string|object $context): ReflectionObject|ReflectionClass
       {
           return is_object($context) ? new ReflectionObject($context) : new ReflectionClass($context);
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

          foreach ($this->getReflection()->getProperties() as $property) {
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
           $isBelong      = $this->isSingleValueAssociation($field);
           $isCollection  = $this->isCollectionValueAssociation($field);

           return ($isBelong || $isCollection);
      }





      /**
       * @param string $column
       *
       * @return bool
      */
      public function hasAttribute(string $column): bool
      {
          return array_key_exists($column, $this->map()->getAttributes());
      }






      /**
       * @return bool
      */
      public function hasIdentifier(): bool
      {
           return array_key_exists($this->identifier, $this->map()->getIdentifiers());
      }








     /**
      * @inheritDoc
     */
     public function isSingleValueAssociation(string $field): bool
     {
          return $this->map()->hasBelong($field);
     }





     /**
      * @inheritDoc
     */
     public function isCollectionValueAssociation(string $field): bool
     {
          if (! $this->hasField($field)) {
              return false;
          }

          $collection = $this->map()->getCollection();

          return $collection->hasCollection($field);
     }







     /**
      * @return $this
     */
     public function map(): static
     {
         $reflection = $this->getReflection();
         $object     = $this->getObject();

         foreach ($reflection->getProperties() as $property) {

             $propertyName = $property->getName();
             $column       = $this->camelCaseToUnderscore($propertyName);
             $value        = $property->getValue($object);

             if ($this->isIdentifier($column)) {
                 $this->identifier = $column;
                 $this->identifiers[$column] = $value;
             } elseif ($value instanceof DateTimeInterface) {
                 $this->attributes[$column] = $value->format('Y-m-d H:i:s');
             } elseif ($value instanceof Collection) {
                 $this->collection->addCollection($column, $value);
             } elseif (is_object($value)) {
                 $this->belongs[$column] = $value;
             } else {
                 $this->attributes[$column] = $value;
             }
             $this->properties[$propertyName] = $value;
         }

         return $this;
     }






    /**
     * @inheritDoc
    */
    public function getIdentifierValues(): array
    {
        return $this->map()->getIdentifiers();
    }





    /**
     * @inheritdoc
    */
    public function getMethods(): array
    {
        $methods = [];

        foreach ($this->reflection->getMethods() as $method) {
           $methods[] = $method->getName();
        }

        return $methods;
    }






    /**
     * @inheritdoc
    */
    public function hasMethod(string $name): bool
    {
        return in_array($name, $this->getMethods());
    }






    /**
     * @return mixed
    */
    public function getIdentifierValue(): mixed
    {
        return $this->identifiers[$this->identifier] ?? null;
    }





    /**
     * @return array
    */
    public function getAttributes(): array
    {
        return $this->attributes;
    }





    /**
     * @param string $column
     *
     * @return bool
    */
    public function hasBelong(string $column): bool
    {
        if (! $this->hasField($column)) {
            return false;
        }

        return isset($this->belongs[$column]);
    }





    /**
     * @return array
    */
    public function getBelongs(): array
    {
        return $this->belongs;
    }






    /**
     * @return PersistenceCollection
    */
    public function getCollection(): PersistenceCollection
    {
        return $this->collection;
    }





    /**
     * @return array
    */
    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }




    /**
     * @return array
    */
    public function getProperties(): array
    {
        return $this->properties;
    }
}