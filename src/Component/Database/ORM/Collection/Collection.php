<?php
namespace Laventure\Component\Database\ORM\Collection;


/**
 * @inheritdoc
*/
abstract class Collection extends \SplObjectStorage
{
    /**
     * @param object $object
     *
     * @return $this
    */
    public function add(object $object): static
    {
        if (! $this->contains($object)) {
            $this->attach($object);
        }

        return $this;
    }





    /**
     * @param object $object
     *
     * @return static
    */
    public function remove(object $object): static
    {
        if ($this->contains($object)) {
            $this->detach($object);
        }

        return $this;
    }
}