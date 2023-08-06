<?php
namespace Laventure\Component\Database\ORM\Persistence;


use Laventure\Component\Database\ORM\Persistence\Manager\EventManager;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadataFactory;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadataInterface;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepositoryFactory;

class Definition
{


         /**
          * @var ClassMetadataFactory
         */
         protected ClassMetadataFactory $metadataFactory;






        /**
         * @var EntityRepositoryFactory
        */
        protected EntityRepositoryFactory $repositoryFactory;







       /**
        * @param EntityRepositoryFactory $repositoryFactory
        *
        * @param ClassMetadataFactory $metadataFactory
       */
       public function __construct(
           ClassMetadataFactory $metadataFactory,
           EntityRepositoryFactory $repositoryFactory,
       )
       {
           $this->metadataFactory   = $metadataFactory;
           $this->repositoryFactory = $repositoryFactory;
       }





       /**
        * @return EntityRepositoryFactory
       */
       public function getRepositoryFactory(): EntityRepositoryFactory
       {
            return $this->repositoryFactory;
       }






      /**
       * @return ClassMetadataFactory
      */
      public function getMetadataFactory(): ClassMetadataFactory
      {
           return $this->metadataFactory;
      }

}