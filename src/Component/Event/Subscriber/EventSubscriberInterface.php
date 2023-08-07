<?php
namespace Laventure\Component\Event\Subscriber;


/**
 * @EventSubscriberInterface
 *
 * @see https://www.php-fig.org/psr/psr-14/
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Event\Subscriber
*/
interface EventSubscriberInterface
{
      /**
       * Returns subscribed events
       *
       * @return array
      */
      public function getSubscribedEvents(): array;
}