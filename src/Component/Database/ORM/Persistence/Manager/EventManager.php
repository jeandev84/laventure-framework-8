<?php
namespace Laventure\Component\Database\ORM\Persistence\Manager;

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
     * @inheritDoc
    */
    public function prePersist(string $event, object $object): static
    {
         $this->listeners[$event][] = $object;

         return $this;
    }






    /**
     * @inheritDoc
    */
    public function preRemove(string $event, object $object): mixed
    {
        // TODO: Implement preRemove() method.
    }




    /**
     * @inheritDoc
    */
    public function preUpdate(string $event, object $object): mixed
    {
        // TODO: Implement preUpdate() method.
    }




    /**
     * @inheritDoc
    */
    public function preFlush(string $event, object $object): mixed
    {
        // TODO: Implement preFlush() method.
    }





    /**
     * @inheritDoc
    */
    public function dispatch(string $event): mixed
    {

    }
}