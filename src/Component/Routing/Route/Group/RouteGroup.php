<?php
namespace Laventure\Component\Routing\Route\Group;


use Closure;

/**
 * @inheritdoc
*/
class RouteGroup implements RouteGroupInterface
{


    /**
     * @var string
    */
    protected string $namespace = '';






    /**
     * @var array
    */
    protected array $path = [];






    /**
     * @var array
    */
    protected array $module = [];






    /**
     * @var array
    */
    protected array $name = [];




    /**
     * @var array
    */
    protected array $middlewares = [];





    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes($attributes);
    }







    /**
     * @inheritdoc
    */
    public function attributes(array $attributes): static
    {
        foreach ($attributes as $name => $value) {
            if (property_exists($this, $name)) {
                call_user_func([$this, $name], $value);
            }
        }

        return $this;
    }





    /**
     * @param string $namespace
     *
     * @return $this
    */
    public function namespace(string $namespace): static
    {
        $this->namespace = trim($namespace, '\\');

        return $this;
    }








    /**
     * @param string $path
     *
     * @return $this
    */
    public function path(string $path): static
    {
        $this->path[] = trim($path, '/');

        return $this;
    }





    /**
     * @return string
    */
    public function getPath(): string
    {
        return join('/', $this->path);
    }





    /**
     * @param string $module
     *
     * @return $this
     */
    public function module(string $module): static
    {
        $this->module[] = rtrim($module, '\\');

        return $this;
    }





    /**
     * @return string
     */
    public function getModule(): string
    {
        return join($this->module);
    }





    /**
     * @param string $name
     *
     * @return $this
    */
    public function name(string $name): static
    {
        $this->name[] = $name;

        return $this;
    }





    /**
     * @return string
     */
    public function getName(): string
    {
        return join($this->name);
    }







    /**
     * @param array $middlewares
     *
     * @return $this
    */
    public function middlewares(array $middlewares): static
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);

        return $this;
    }







    /**
     * @inheritdoc
    */
    public function getMiddlewares(): array
    {
         return $this->middlewares;
    }







    /**
     * @return string
    */
    public function getNamespace(): string
    {
        if (! $this->namespace) { return ''; }

        if ($module = $this->getModule()) {
            return sprintf('%s\\%s', $this->namespace , $module);
        }

        return $this->namespace;
    }








    /**
     * @inheritDoc
    */
    public function callRoutes(Closure $routes, array $arguments = []): static
    {
         call_user_func_array($routes, $arguments);

         return $this;
    }





    /**
     * @param array $attributes
     *
     * @param Closure $routes
     *
     * @param array $arguments
     *
     * @return $this
    */
    public function map(array $attributes, Closure $routes, array $arguments): static
    {
         $this->attributes($attributes);
         $this->callRoutes($routes, $arguments);
         $this->rewind();

         return $this;
    }








    /**
     * @inheritDoc
    */
    public function rewind(): void
    {
        $this->path   = [];
        $this->module = [];
        $this->middlewares = [];
        $this->name = [];
    }






    /**
     * @inheritdoc
    */
    public function getPrefixes(): array
    {
        return [
            'path'        => $this->getPath(),
            'namespace'   => $this->getNamespace(),
            'name'        => $this->getName()
        ];
    }
}