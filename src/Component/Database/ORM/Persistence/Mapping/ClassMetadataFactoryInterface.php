<?php
namespace Laventure\Component\Database\ORM\Persistence\Mapping;



interface ClassMetadataFactoryInterface
{
      /**
       * @param string $classname
       *
       * @return ClassMetadata
      */
      public function createClassMetadata(string $classname): ClassMetadata;
}