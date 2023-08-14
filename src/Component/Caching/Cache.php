<?php
namespace Laventure\Component\Caching;

use Laventure\Component\Caching\Adapter\CacheAdapter;
use Laventure\Component\Caching\Exception\InvalidArgumentException;
use Laventure\Component\Caching\Item\CacheItemInterface;

/**
 * @Cache
 *
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Caching
*/
class Cache
{


    /**
     * @param CacheAdapter $cache
    */
    public function __construct(protected CacheAdapter $cache)
    {

    }





    /**
     * @param string $key
     *
     * @return CacheItemInterface
     *
     * @throws InvalidArgumentException
    */
    public function getItem(string $key): CacheItemInterface
    {
        return $this->cache->getItem($key);
    }










    /**
     * @param array $keys
     *
     * @return iterable
     *
     * @throws InvalidArgumentException
    */
    public function getItems(array $keys = []): iterable
    {
        return $this->cache->getItems($keys);
    }











    /**
     * @param string $key
     *
     * @return bool
     *
     * @throws InvalidArgumentException
    */
    public function hasItem(string $key): bool
    {
        return $this->cache->hasItem($key);
    }











    /**
     * @return bool
    */
    public function clear(): bool
    {
        return $this->cache->clear();
    }









    /**
     * @param string $key
     *
     * @return bool
     *
     * @throws InvalidArgumentException
    */
    public function deleteItem(string $key): bool
    {
        return $this->cache->deleteItem($key);
    }












    /**
     * @param array $keys
     *
     * @return bool
     *
     * @throws InvalidArgumentException
    */
    public function deleteItems(array $keys): bool
    {
        return $this->cache->deleteItems($keys);
    }











    /**
     * @param CacheItemInterface $item
     *
     * @return bool
    */
    public function save(CacheItemInterface $item): bool
    {
        return $this->save($item);
    }










    /**
     * @param CacheItemInterface $item
     *
     * @return bool
    */
    public function saveDeferred(CacheItemInterface $item): bool
    {
        return $this->cache->saveDeferred($item);
    }






    /**
     * @return bool
    */
    public function commit(): bool
    {
        return $this->commit();
    }
}