<?php
namespace Laventure\Component\Event\Dispatcher;

use Laventure\Component\Event\Listener\ListenerProviderInterface;
use Laventure\Component\Event\StoppableEventInterface;


/**
 * @inheritdoc
*/
class EventDispatcher implements EventDispatcherInterface
{


    /**
     * @param ListenerProviderInterface $listenerProvider
    */
    public function __construct(protected ListenerProviderInterface $listenerProvider)
    {
    }




    /**
     * @inheritDoc
    */
    public function dispatch(object $event): object
    {
        if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
            return $event;
        }

        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $listener($event);
        }

        return $event;
    }
}