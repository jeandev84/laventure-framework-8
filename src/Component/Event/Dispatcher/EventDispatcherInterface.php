<?php
namespace Laventure\Component\Event\Dispatcher;

/**
 * @EventDispatcherInterface
 *
 * @see https://www.php-fig.org/psr/psr-14/
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Event\Dispatcher
 *
 * Defines a dispatcher for events.
*/
interface EventDispatcherInterface
{
    /**
     * Provide all relevant listeners with an event to process.
     *
     * @param object $event The object to process.
     *
     * @return object The Event that was passed, now modified by listeners.
    */
    public function dispatch(object $event): object;
}