<?php
namespace Laventure\Component\Database\ORM\Persistence;


use Laventure\Component\Database\ORM\Persistence\Manager\EventManager;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadataInterface;
use Laventure\Component\Database\ORM\Persistence\Repository\EntityRepositoryFactory;

class Definition
{


       /**
        * @var EntityRepositoryFactory
       */
       protected EntityRepositoryFactory $repositoryFactory;




       /**
        * @var EventManager
       */
       protected EventManager $eventManager;




       /**
        * @var ClassMetadata
       */
       protected ClassMetadata $metadata;






       /**
         * @param EntityRepositoryFactory $repositoryFactory
         *
         * @param EventManager $eventManager
       */
       public function __construct(EntityRepositoryFactory $repositoryFactory, EventManager $eventManager)
       {
           $this->repositoryFactory = $repositoryFactory;
           $this->eventManager      = $eventManager;
       }





       /**
        * @return EntityRepositoryFactory
       */
       public function getRepositoryFactory(): EntityRepositoryFactory
       {
            return $this->repositoryFactory;
       }







       /**
        * @return EventManager
       */
       public function getEventManager(): EventManager
       {
           return $this->eventManager;
       }





      /**
       * @return ClassMetadata
      */
      public function getClassMetadata(): ClassMetadata
      {

      }

}