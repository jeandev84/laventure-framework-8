<?php
namespace Laventure\Component\Routing\Route\Group;


use Closure;

/**
 * @RouteGroupInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Routing\Route\Group
*/
interface RouteGroupInterface
{


    /**
     * @param array $attributes
     *
     * @return mixed
    */
    public function attributes(array $attributes): mixed;





    /**
     * Map routes
     *
     * @param Closure $routes
     *
     * @param array $arguments
     *
     * @return mixed
    */
    public function callRoutes(Closure $routes, array $arguments = []): mixed;







    /**
     * Reset route attributes
     *
     * @return void
    */
    public function rewind(): void;






    /**
     * Returns namespace
     *
     * @return string
    */
    public function getNamespace(): string;






    /**
     * Returns route prefixes
     *
     * @return array
    */
    public function getPrefixes(): array;







    /**
     * Returns group middlewares
     *
     * @return array
    */
    public function getMiddlewares(): array;
}