<?php
namespace Laventure\Component\Database\ORM\Persistence\Repository;


use Laventure\Component\Database\ORM\Persistence\EntityManager;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;


/**
 * @inheritdoc
*/
class ServiceRepository extends EntityRepository
{

      /**
       * @param EntityManager $em
       *
       * @param string $classname
     */
     public function __construct(EntityManager $em, string $classname)
     {
         parent::__construct($em, new ClassMetadata($classname));
     }
}