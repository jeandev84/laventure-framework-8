<?php
namespace Laventure\Component\Event\Listener;


use Laventure\Component\Event\Subscriber\EventSubscriberInterface;

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
     * @var EventSubscriberInterface[]
    */
    protected array $subscribers = [];





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
     * @param array $listeners
     *
     * @return $this
    */
    public function addListeners(array $listeners): static
    {
         foreach ($listeners as $eventName => $callback) {
              $this->addListener($eventName, $callback);
         }

         return $this;
    }




    /**
     * @param EventSubscriberInterface $subscriber
     *
     * @return $this
    */
    public function addSubscriber(EventSubscriberInterface $subscriber): static
    {
         foreach ($subscriber->getSubscribedEvents() as $event => $callback) {
               $this->addListener($event, $callback);
         }

         $this->subscribers[get_class($subscriber)] = $subscriber;

         return $this;
    }






    /**
     * @param EventSubscriberInterface[] $subscribers
     *
     * @return $this
    */
    public function addSubscribers(array $subscribers): static
    {
         foreach ($subscribers as $subscriber) {
             $this->addSubscriber($subscriber);
         }

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