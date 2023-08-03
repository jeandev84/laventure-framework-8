<?php
namespace Laventure\Component\Routing;


use Closure;
use Laventure\Component\Routing\Route\Collection\RouteCollection;
use Laventure\Component\Routing\Route\Group\RouteGroup;
use Laventure\Component\Routing\Route\Route;
use Laventure\Component\Routing\Route\RouteResolver;


/**
 * @inheritdoc
*/
class Router implements RouterInterface
{




    /**
     * Route collection
     *
     * @var RouteCollection
   */
    protected RouteCollection $collection;





    /**
     * Route group
     *
     * @var RouteGroup
    */
    protected RouteGroup $group;





    /**
     * Route domain
     *
     * @var string
    */
    protected string $domain;





    /**
     * Locale language
     *
     * @var string
    */
    protected string $locale;






    /**
     * @var Resource[]
    */
    public $resources = [];






    /**
     * Route patterns
     *
     * @var array
    */
    protected array $patterns = [
        'id' => '\d+'
    ];





    /**
     * Route middlewares
     *
     * @var array
    */
    protected array $middlewares = [];






    /**
     * Router constructor.
     *
     * @param string $domain
    */
    public function __construct(string $domain)
    {
        $this->domain     = $domain;
        $this->collection = new RouteCollection();
        $this->group      = new RouteGroup();
    }






    /**
     * @param string $namespace
     *
     * @return $this
    */
    public function namespace(string $namespace): static
    {
        $this->group->namespace($namespace);

        return $this;
    }



    

    /**
     * @param string $path
     *
     * @return $this
    */
    public function path(string $path): static
    {
        $this->group->path($path);

        return $this;
    }






    /**
     * @param string $module
     *
     * @return $this
    */
    public function module(string $module): static
    {
        $this->group->module($module);

        return $this;
    }






    /**
     * @param string $name
     *
     * @return $this
    */
    public function name(string $name): static
    {
        $this->group->name($name);

        return $this;
    }






    /**
     * @param array $attributes
     *
     * @param Closure $routes
     *
     * @return $this
    */
    public function group(array $attributes, Closure $routes): static
    {
        $this->group->map($attributes, $routes, [$this]);

        return $this;
    }






    /**
     * Map route
     *
     * @param $methods
     *
     * @param $path
     *
     * @param $action
     *
     * @param $name
     *
     * @return Route
    */
    public function map($methods, $path, $action, $name): Route
    {
        return $this->addRoute($this->makeRoute($methods, $path, $action, $name));
    }







    /**
     * Map route called by method GET
     *
     * @param $path
     *
     * @param $action
     *
     * @param $name
     *
     * @return Route
    */
    public function get($path, $action, $name): Route
    {
        return $this->map('GET', $path, $action, $name);
    }






    /**
     * Map route called by method POST
     *
     * @param $path
     *
     * @param $action
     *
     * @param $name
     *
     * @return Route
    */
    public function post($path, $action, $name): Route
    {
        return $this->map('POST', $path, $action, $name);
    }





    /**
     * Map route called by method PUT
     *
     * @param $path
     *
     * @param $action
     *
     * @param $name
     *
     * @return Route
    */
    public function put($path, $action, $name): Route
    {
        return $this->map('PUT', $path, $action, $name);
    }







    /**
     * Map route called by method PATCH
     *
     * @param $path
     *
     * @param $action
     *
     * @param $name
     *
     * @return Route
    */
    public function patch($path, $action, $name): Route
    {
        return $this->map('PATCH', $path, $action, $name);
    }







    /**
     * Map route called by method DELETE
     *
     * @param $path
     *
     * @param $action
     *
     * @param $name
     *
     * @return Route
    */
    public function delete($path, $action, $name): Route
    {
        return $this->map('DELETE', $path, $action, $name);
    }








    /**
     * @inheritDoc
    */
    public function match(string $method, string $path): mixed
    {
        foreach ($this->getRoutes() as $route) {
            if ($route->match($method, $path)) {
                return $route;
            }
        }

        return false;
    }







    /**
     * @inheritDoc
    */
    public function generate(string $name, array $parameters = []): ?string
    {
         if (! $route = $this->collection->getRouteByName($name)) {
             return null;
         }

         return $route->generateUri($parameters);
    }







    /**
     * @param $methods
     *
     * @param $path
     *
     * @param $action
     *
     * @param $name
     *
     * @return Route
    */
    public function makeRoute($methods, $path, $action, $name): Route
    {
          $route = new Route(
              $this->domain,
              $methods,
              $this->resolvePath($path),
              $this->resolveAction($action),
              $name
          );

          $route->middlewareStack($this->middlewares)
               ->wheres($this->patterns)
               ->middleware($this->group->getMiddlewares());

          return $route;
    }





    /**
     * @inheritDoc
     */
    public function getDomain(): string
    {
        return $this->domain;
    }







    /**
     * Returns route collection
     *
     * @return RouteCollection
    */
    public function getCollection(): RouteCollection
    {
        return $this->collection;
    }







    /**
     * @inheritDoc
    */
    public function getRoutes(): array
    {
        return $this->collection->getRoutes();
    }






    /**
     * @param Route $route
     *
     * @return Route
    */
    public function addRoute(Route $route): Route
    {
        return $this->collection->addRoute($route);
    }





    /**
     * @param string $path
     *
     * @return string
    */
    private function resolvePath(string $path): string
    {
        if ($prefix = $this->group->getPath()) {
            $path = trim($prefix, '/') . '/' . ltrim($path, '/');
        }

        return $path;
    }







    /**
     * @param mixed $action
     *
     * @return mixed
    */
    private function resolveAction(mixed $action): mixed
    {
        if (is_string($action)) {
            $action = $this->resolveActionFromString($action);
        }

        return $action;
    }





    /**
     * @param string $action
     *
     * @return array|string
    */
    private function resolveActionFromString(string $action): array|string
    {
        if (stripos($action, '@') !== false) {
            $action     = explode('@', $action, 2);
            $controller = sprintf('%s\\%s', $this->group->getNamespace(), $action[0]);
            return [$controller, $action[1]];
        }

        return $action;
    }
}