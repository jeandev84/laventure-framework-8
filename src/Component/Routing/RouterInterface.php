<?php
namespace Laventure\Component\Routing;

use Laventure\Component\Routing\Route\Route;

/**
 * @RouterInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Routing
*/
interface RouterInterface
{


    /**
     * Returns route domain
     *
     * @return string
    */
    public function getDomain(): string;





    /**
     * Returns all routes
     *
     * @return Route[]
    */
    public function getRoutes(): array;







    /**
     * Determine if the current request match route
     *
     * @param string $method
     *
     * @param string $path
     *
     * @return mixed
    */
    public function match(string $method, string $path): mixed;








    /**
     * Generate route URI
     *
     * @param string $name
     *
     * @param array $parameters
     *
     * @return string|null
    */
    public function generate(string $name, array $parameters = []): ?string;
}