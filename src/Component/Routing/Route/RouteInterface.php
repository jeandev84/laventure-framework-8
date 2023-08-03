<?php
namespace Laventure\Component\Routing\Route;


/**
 * @RouterInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Routing\Route
*/
interface RouteInterface extends \ArrayAccess
{

    /**
     * Return route domain or host
     *
     * @return string
     */
    public function getDomain(): string;




    /**
     * Returns route methods
     *
     * @return array
    */
    public function getMethods(): array;




    /**
     * Returns route path
     *
     * @return string
    */
    public function getPath(): string;





    /**
     * Returns route handler will be done something
     *
     * @return mixed
     */
    public function getAction(): mixed;








    /**
     * Return name of route
     *
     * @return string
     */
    public function getName(): string;





    /**
     * Returns route matches params
     *
     * @return array
    */
    public function getParams(): array;





    /**
     * Return route middlewares
     *
     * @return array
    */
    public function getMiddlewares(): array;





    /**
     * Returns route options
     *
     * @return array
    */
    public function getOptions(): array;





    /**
     * Determine if route match method
     *
     * @param string $requestMethod
     *
     * @return bool
    */
    public function matchMethod(string $requestMethod): bool;








    /**
     * Determine if route match path
     *
     * @param string $requestPath
     *
     * @return bool
    */
    public function matchPath(string $requestPath): bool;






    /**
     * Generate route uri from given params
     *
     * @param array $parameters
     *
     * @return string
    */
    public function generateUri(array $parameters = []): string;
}