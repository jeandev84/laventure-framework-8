<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;


use Laventure\Component\Database\ORM\Persistence\Manager\Event\ObjectEvent;

/**
 * @EventManagerInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\Persistence\Manager
*/
interface EventManagerInterface
{


      /**
       * @param ObjectEvent $event
       *
       * @return ObjectEvent
      */
      public function dispatchEvent(ObjectEvent $event): ObjectEvent;

}