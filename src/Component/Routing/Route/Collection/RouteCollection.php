<?php
namespace Laventure\Component\Routing\Route\Collection;


use Laventure\Component\Routing\Route\Route;


/**
 * @inheritdoc
*/
class RouteCollection implements RouteCollectionInterface
{


    /**
     * @var Route[]
     */
    protected array $routes = [];




    /**
     * @var Route[]
     */
    protected array $methods = [];




    /**
     * @var Route[]
    */
    protected array $controllers = [];






    /**
     * @var Route[]
    */
    protected array $namedRoutes = [];






    /**
     * @param Route $route
     *
     * @return Route
    */
    public function addRoute(Route $route): Route
    {
        $this->methods[$route->getMethod()][] = $route;

        if ($controller = $route->getController()) {
            $this->controllers[$controller][] = $route;
        }

        if($name = $route->getName()) {
            $this->namedRoutes[$name] = $route;
        }

        return $this->routes[] = $route;
    }








    /**
     * Add routes
     *
     * @param Route[] $routes
     *
     * @return $this
    */
    public function addRoutes(array $routes): static
    {
        foreach ($routes as $route) {
            $this->addRoute($route);
        }

        return $this;
    }








    /**
     * @inheritDoc
    */
    public function getRoutes(): array
    {
        return $this->routes;
    }





    /**
     * @return Route[]
     */
    public function getRoutesByMethod(): array
    {
        return $this->methods;
    }






    /**
     * @return Route[]
    */
    public function getRoutesByController(): array
    {
        return $this->controllers;
    }





    /**
     * @return Route[]
    */
    public function getRoutesByName(): array
    {
        return $this->namedRoutes;
    }






    /**
     * @param string $name
     *
     * @return Route|null
    */
    public function getRouteByName(string $name): ?Route
    {
        return $this->namedRoutes[$name] ?? null;
    }
}