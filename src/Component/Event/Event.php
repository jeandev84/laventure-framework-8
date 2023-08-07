<?php
namespace Laventure\Component\Event;


/**
 * @Event
 *
 * @see https://www.php-fig.org/psr/psr-14/
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Event
*/
class Event implements StoppableEventInterface
{


    /**
     * @var bool Whether no further event listeners should be triggered
    */
    private bool $propagationStopped = false;




    /**
     * @inheritDoc
    */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }



    /**
     * Stops the propagation of the event to further event listeners.
     *
     * If multiple event listeners are connected to the same event, no
     * further event listener will be triggered once any trigger calls
     * stopPropagation().
    */
    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}