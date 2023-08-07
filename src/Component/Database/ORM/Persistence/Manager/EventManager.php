<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;


use Laventure\Component\Database\ORM\Persistence\Manager\Event\ObjectEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PostPersistEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PostRemoveEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PostUpdateEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PrePersistEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PreRemoveEvent;
use Laventure\Component\Database\ORM\Persistence\Manager\Events\PreUpdateEvent;
use Laventure\Component\Database\ORM\Persistence\Mapping\ClassMetadata;

/**
 * @inheritdoc
*/
class EventManager implements EventManagerInterface
{

    /**
     * @var array
    */
    protected array $listeners = [];






    /**
     * @param string $eventName
     *
     * @param callable $callable
     *
     * @return $this
    */
    public function addListener(string $eventName, callable $callable): static
    {
        $this->listeners[$eventName][] = $callable;

        return $this;
    }




    /**
     * @param array $listeners
     *
     * @return $this
    */
    public function addListeners(array $listeners): static
    {
        foreach ($listeners as $event => $listener) {
            $this->addListener($event, $listener);
        }

        return $this;
    }





    /**
     * @return void
    */
    public function subscribePersistEvents(): void
    {
         $this->addListeners([
             PrePersistEvent::class   => [$this, Event::prePersist],
             PostPersistEvent::class  => [$this, Event::postPersist],
             PreUpdateEvent::class    => [$this, Event::preUpdate],
             PostUpdateEvent::class   => [$this, Event::postUpdate]
         ]);
    }




    /**
     * @return void
    */
    public function subscribeRemoveEvents(): void
    {
         $this->addListeners([
             PreRemoveEvent::class    => [$this, Event::preRemove],
             PostRemoveEvent::class   => [$this, Event::postRemove],
         ]);
    }







    /**
     * @param PrePersistEvent $event
     *
     * @return void
    */
    public function prePersist(PrePersistEvent $event): void
    {
         $this->call($event, Event::prePersist);
    }




    /**
     * @param PostPersistEvent $event
     *
     * @return void
    */
    public function postPersist(PostPersistEvent $event): void
    {
        $this->call($event, Event::postPersist);
    }







    /**
     * @inheritDoc
    */
    public function dispatchEvent(ObjectEvent $event): ObjectEvent
    {
         $eventName = get_class($event);

         if (array_key_exists($eventName, $this->listeners)) {
              foreach ($this->listeners[$eventName] as $listener) {
                  $listener($event);
              }
         }

         return $event;
    }




    /**
     * @param object $object
     *
     * @return ClassMetadata
    */
    private function metadata(object $object): ClassMetadata
    {
        return new ClassMetadata($object);
    }






    /**
     * @param ObjectEvent $event
     *
     * @param string $method
     *
     * @return void
    */
    private function call(ObjectEvent $event, string $method): void
    {
        if (is_callable([$this, $method])) {

            $object = $event->getSubject();

            if($this->metadata($object)->hasMethod($method)) {
                call_user_func([$object, $method], $event);
            }
        }

    }

}