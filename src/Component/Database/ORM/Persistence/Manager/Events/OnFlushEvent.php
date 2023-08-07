<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager\Events;


use Laventure\Component\Database\ORM\Persistence\EntityManager;

class OnFlushEvent
{
    /**
     * @param EntityManager $em
   */
    public function __construct(protected EntityManager $em)
    {
    }





    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->em;
    }
}