<?php
namespace Laventure\Component\Event\Listener;


/**
 * @inheritdoc
*/
class ListenerProvider implements ListenerProviderInterface
{


    /**
     * @var array
    */
    protected array $listeners = [];




    /**
     * @param string $eventName
     *
     * @param callable $callback
     *
     * @return $this
    */
    public function addListener(string $eventName, callable $callback): static
    {
         $this->listeners[$eventName][] = $callback;

         return $this;
    }






    /**
     * @inheritDoc
    */
    public function getListenersForEvent(object $event): iterable
    {
          $eventName = get_class($event);

          if (! array_key_exists($eventName, $this->listeners)) {
               return [];
          }

          return $this->listeners[$eventName];
    }








    /**
     * @param string $eventName
     *
     * @return void
    */
    public function clearListeners(string $eventName): void
    {
        if (array_key_exists($eventName, $this->listeners)) {
            unset($this->listeners[$eventName]);
        }
    }
}