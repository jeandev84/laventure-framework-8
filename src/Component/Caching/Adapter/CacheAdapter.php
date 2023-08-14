<?php
namespace Laventure\Component\Caching\Adapter;

use Closure;
use Laventure\Component\Caching\Pool\CacheItemPoolInterface;


/**
 * @inheritdoc
*/
abstract class CacheAdapter implements CacheItemPoolInterface
{


//       /**
//        * @param string $key
//        *
//        * @param Closure $item
//        *
//        * @return mixed
//       */
//       public function get(string $key, Closure $item): mixed
//       {
//            if ($this->hasItem($key)) {
//                 return $this->getItem($key);
//            }
//
//            $this->save();
//       }
}