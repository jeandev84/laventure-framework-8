<?php
namespace Laventure\Component\Routing\Route\Collection;


use Laventure\Component\Routing\Route\Route;

/**
 * @RouteCollectionInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Routing\Route\Collection
*/
interface RouteCollectionInterface
{

     /**
      * Returns all routes
      *
      * @return Route[]
     */
     public function getRoutes(): array;
}