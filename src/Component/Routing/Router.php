<?php
namespace Laventure\Component\Routing;


use Closure;
use Laventure\Component\Routing\Resource\ApiResource;
use Laventure\Component\Routing\Resource\Types\ResourceType;
use Laventure\Component\Routing\Resource\WebResource;
use Laventure\Component\Routing\Route\Collection\RouteCollection;
use Laventure\Component\Routing\Route\Group\RouteGroup;
use Laventure\Component\Routing\Route\Route;
use Laventure\Component\Routing\Resource\Contract\Resource;



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
    public array $resources = [];






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
     * @param string $name
     *
     * @param string $controller
     *
     * @return $this
    */
    public function resource(string $name, string $controller): static
    {
        return $this->addResource(new WebResource($name, $controller));
    }







    /**
     * @param array $resources
     *
     * @return $this
     */
    public function resources(array $resources): static
    {
        foreach ($resources as $name => $controller) {
            $this->resource($name, $controller);
        }

        return $this;
    }





    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasResource(string $name): bool
    {
        return isset($this->resources[ResourceType::WEB][$name]);
    }






    /**
     * @param string $name
     *
     * @return WebResource|null
    */
    public function getResource(string $name): ?WebResource
    {
        return $this->resources[ResourceType::WEB][$name] ?? null;
    }







    /**
     * @param string $name
     *
     * @param string $controller
     *
     * @return $this
     */
    public function apiResource(string $name, string $controller): static
    {
        return $this->addResource(new ApiResource($name, $controller));
    }






    /**
     * @param array $resources
     *
     * @return $this
     */
    public function apiResources(array $resources): static
    {
         foreach ($resources as $name => $controller) {
            $this->apiResource($name, $controller);
         }

         return $this;
    }






    /**
     * @param string $name
     *
     * @return bool
    */
    public function hasApiResource(string $name): bool
    {
        return isset($this->resources[ResourceType::API][$name]);
    }





    /**
     * @param string $name
     *
     * @return ApiResource|null
    */
    public function getApiResource(string $name): ?ApiResource
    {
        return $this->resources[ResourceType::API][$name] ?? null;
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
     * @param array|string $methods
     *
     * @param string $path
     *
     * @param mixed $action
     *
     * @param string $name
     *
     * @return Route
    */
    public function makeRoute(array|string $methods, string $path, mixed $action, string $name): Route
    {
          $route = new Route(
              $this->domain,
              $methods,
              $this->group->resolvePath($path),
              $this->group->resolveAction($action),
              $this->group->resolveName($name)
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
     * @param Resource $resource
     *
     * @return $this
    */
    public function addResource(Resource $resource): static
    {
        $resource->map($this);

        $type = $resource->getTypeName();
        $name = $resource->getName();

        $this->resources[$type][$name] = $resource;

        return $this;
    }
}