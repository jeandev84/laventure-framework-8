<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;


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
     * @param string $event
     *
     * @return bool
    */
    public function hasListener(string $event): bool
    {
         return isset($this->listeners[$event]);
    }




    /**
     * @return array
    */
    public function getListeners(): array
    {
        return $this->listeners;
    }






    /**
     * @return void
    */
    public function subscribePersistEvents(): void
    {
         foreach ($this->persistEvents() as $event => $callback) {
              if (! $this->hasListener($event)) {
                  $this->addListener($event, $callback);
              }
         }
    }





    /**
     * @return void
    */
    public function subscribeRemoveEvents(): void
    {
        foreach ($this->removeEvents() as $event => $callback) {
            if (! $this->hasListener($event)) {
                $this->addListener($event, $callback);
            }
        }
    }







    /**
     * @inheritDoc
    */
    public function dispatchEvent(object $event): object
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
        $object = $event->getSubject();

        if($this->metadata($object)->hasMethod($method)) {
            call_user_func([$object, $method], $event);
        }
    }





    /**
     * @param PrePersistEvent $event
     *
     * @return void
    */
    private function prePersist(PrePersistEvent $event): void
    {
        $this->call($event, Event::prePersist);
    }




    /**
     * @param PostPersistEvent $event
     *
     * @return void
    */
    private function postPersist(PostPersistEvent $event): void
    {
        $this->call($event, Event::postPersist);
    }




    /**
     * @param PreUpdateEvent $event
     *
     * @return void
    */
    private function preUpdate(PreUpdateEvent $event): void
    {
        $this->call($event, Event::preUpdate);
    }





    /**
     * @param PostUpdateEvent $event
     *
     * @return void
    */
    private function postUpdate(PostUpdateEvent $event): void
    {
        $this->call($event, Event::postUpdate);
    }




    /**
     * @param PreRemoveEvent $event
     *
     * @return void
    */
    private function preRemove(PreRemoveEvent $event): void
    {
        $this->call($event, Event::preRemove);
    }




    /**
     * @param PostRemoveEvent $event
     *
     * @return void
    */
    private function postRemove(PostRemoveEvent $event): void
    {
        $this->call($event, Event::postRemove);
    }




    /**
     * @return array[]
    */
    private function persistEvents(): array
    {
        return [
            PrePersistEvent::class   => [$this, Event::prePersist],
            PostPersistEvent::class  => [$this, Event::postPersist],
            PreUpdateEvent::class    => [$this, Event::preUpdate],
            PostUpdateEvent::class   => [$this, Event::postUpdate]
        ];
    }





    /**
     * @return array[]
    */
    private function removeEvents(): array
    {
        return [
            PreRemoveEvent::class    => [$this, Event::preRemove],
            PostRemoveEvent::class   => [$this, Event::postRemove],
        ];
    }
}