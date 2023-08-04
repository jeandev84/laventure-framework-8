<?php
namespace Laventure\Component\Routing\Collection;


use Laventure\Component\Routing\Route\Route;


/**
 * @inheritdoc
*/
class RouteCollection implements RouteCollectionInterface
{


    /**
     * @var Route[]
    */
    protected ?array $routes = [];




    /**
     * @var Route[]
    */
    protected ?array $methods = [];




    /**
     * @var Route[]
    */
    protected ?array $controllers = [];






    /**
     * @var Route[]
    */
    protected ?array $namedRoutes = [];






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
     * Returns routes by method
     *
     * @return Route[]
    */
    public function getMethods(): array
    {
        return $this->methods;
    }

    
    
    

    /**
     * Returns all routes of method
     *
     * @return Route[]
    */
    public function getRoutesByMethod(string $method): array
    {
        return $this->methods[$method] ?? [];
    }



    


    /**
     * Returns all routes of controller
     *
     * @param string $controller
     *
     * @return Route[]
    */
    public function getRoutesByController(string $controller): array
    {
         return $this->controllers[$controller] ?? [];
    }





    /**
     * Returns all routes by controller
     *
     * @return Route[]
    */
    public function getControllers(): array
    {
        return $this->controllers;
    }





    /**
     * Returns all named routes
     *
     * @return Route[]
    */
    public function getNamedRoutes(): array
    {
        return $this->namedRoutes;
    }






    /**
     * @inheritdoc
    */
    public function getRoute(string $name): ?Route
    {
        return $this->namedRoutes[$name] ?? null;
    }







    /**
     * @inheritdoc
    */
    public function hasRoute(string $name): bool
    {
        return isset($this->namedRoutes[$name]);
    }
}