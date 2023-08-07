<?php
namespace Laventure\Component\Event\Listener;


/**
 * @ListenerProviderInterface
 *
 * @see https://www.php-fig.org/psr/psr-14/
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Event\Listener
 *
 * Mapper from an event to the listeners that are applicable to that event.
*/
interface ListenerProviderInterface
{

    /**
     * @param object $event An event for which to return the relevant listeners.
     *
     * @return iterable<callable>
     *
     * An iterable (array, iterator, or generator) of callables.
     * Each callable MUST be type-compatible with $event.
    */
    public function getListenersForEvent(object $event) : iterable;
}