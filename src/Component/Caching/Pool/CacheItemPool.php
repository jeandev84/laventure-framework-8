<?php
namespace Laventure\Component\Caching\Pool;

/**
 * @inheritdoc
*/
abstract class CacheItemPool extends \CachingIterator implements CacheItemPoolInterface
{

    /**
     * @inheritDoc
    */
    public function getItem($key)
    {
        // TODO: Implement getItem() method.
    }




    /**
     * @inheritDoc
    */
    public function getItems(array $keys = [])
    {
        // TODO: Implement getItems() method.
    }





    /**
     * @inheritDoc
    */
    public function hasItem($key): bool
    {
        // TODO: Implement hasItem() method.
    }





    /**
     * @inheritDoc
    */
    public function clear(): bool
    {
        // TODO: Implement clear() method.
    }




    /**
     * @inheritDoc
    */
    public function deleteItem($key): bool
    {
        // TODO: Implement deleteItem() method.
    }




    /**
     * @inheritDoc
    */
    public function deleteItems(array $keys): bool
    {
        // TODO: Implement deleteItems() method.
    }




    /**
     * @inheritDoc
    */
    public function save(CacheItemInterface $item): bool
    {
        // TODO: Implement save() method.
    }





    /**
     * @inheritDoc
    */
    public function saveDeferred(CacheItemInterface $item): bool
    {
        // TODO: Implement saveDeferred() method.
    }




    /**
     * @inheritDoc
    */
    public function commit(): bool
    {
        // TODO: Implement commit() method.
    }
}