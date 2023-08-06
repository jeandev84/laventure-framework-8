<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapping;


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
       protected string $table;





       /**
         * @param string|object $classname
         *
         * @param string|null $table
       */
       public function __construct(string|object $classname, string $table = null)
       {
           try {

               $reflection       = new ReflectionClass($classname);
               $this->table      = $table ?: $this->tableName($reflection);
               $this->reflection = $reflection;

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
       * @param ReflectionClass $reflection
       *
       * @return string
      */
      private function tableName(ReflectionClass $reflection): string
      {
           $shortName = $reflection->getShortName();
           return mb_strtolower("{$shortName}s");
      }

}