<?php
namespace Laventure\Component\Routing\Route;


use Closure;


/**
 * @Route
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Routing\Route
 */
class Route implements RouteInterface
{



    /**
     * Route domain
     *
     * @var  string
    */
    protected string $domain;




    /**
     * Route path
     *
     * @var string
    */
    protected string $path;





    /**
     * Route pattern
     *
     * @var string
    */
    protected string $pattern;





    /**
     * Route action.
     *
     * @var mixed
    */
    protected mixed $action;




    /**
     * Route name
     *
     * @var string
    */
    protected string $name = '';








    /**
     * Route methods
     *
     * @var array
    */
    protected array $methods = [];





    /**
     * Route params
     *
     * @var array
    */
    protected array $params = [];







    /**
     * Route middlewares
     *
     * @var array
    */
    protected array $middlewares = [];






    /**
     * Route patterns
     *
     * @var array
    */
    protected array $patterns = [];








    /**
     * Route options
     *
     * @var array
    */
    protected array $options = [];





    /**
     * @var array
    */
    private static array $wheres = [];





    /**
     * @var array
    */
    private static array $middlewareStack = [];





    /**
     * @param string $domain
     *
     * @param array|string $methods
     *
     * @param string $path
     *
     * @param mixed $action
     *
     * @param string $name
    */
    public function __construct(string $domain, array|string $methods, string $path, mixed $action, string $name = '')
    {
         $this->domain($domain)
              ->methods($methods)
              ->path($path)
              ->action($action)
              ->name($name);
    }







    /**
     * @param array $middlewares
     *
     * @return $this
    */
    public function middlewareStack(array $middlewares): static
    {
        static::$middlewareStack = array_merge(static::$middlewareStack, $middlewares);

        return $this;
    }







    /**
     * @param string|array $middlewares
     *
     * @return $this
    */
    public function middleware(string|array $middlewares): static
    {
        $middlewares = $this->resolveMiddlewares((array)$middlewares);

        $this->middlewares = array_merge($this->middlewares, $middlewares);

        return $this;
    }






    /**
     * @param string $name
     *
     * @return $this
    */
    public function only(string $name): static
    {
        $this->middlewares = [];

        return $this->middleware($name);
    }







    /**
     * @param array $options
     *
     * @return $this
    */
    public function options(array $options): static
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }






    /**
     * @param string $name
     *
     * @param $default
     *
     * @return mixed|null
    */
    public function option(string $name, $default = null): mixed
    {
        return $this->options[$name] ?? $default;
    }


    
    
    
    
    
    /**
     * @param callable $action
     * 
     * @return $this
    */
    public function callback(callable $action): static
    {
        $this->action = $action;
        
        return $this;
    }







    /**
     * Set route pattern
     *
     * @param string $name
     *
     * @param string $pattern
     *
     * @return $this
    */
    public function where(string $name, string $pattern): static
    {
        self::$wheres[$name]    = $this->makePatterns($name, $pattern);
        $this->patterns[$name]  = $pattern;

        return $this;
    }






    /**
     * @param array $patterns
     *
     * @return $this
     */
    public function wheres(array $patterns): static
    {
        foreach ($patterns as $name => $pattern) {
            $this->where($name, $pattern);
        }

        return $this;
    }






    /**
     * @param string $name
     * @return $this
     */
    public function number(string $name): self
    {
        return $this->where($name, '\d+');
    }





    /**
     * @param string $name
     * @return $this
     */
    public function text(string $name): self
    {
        return $this->where($name, '\w+');
    }






    /**
     * @param string $name
     * @return $this
     */
    public function alphaNumeric(string $name): self
    {
        return $this->where($name, '[^a-z_\-0-9]');
    }





    /**
     * @param string $name
     * @return $this
    */
    public function slug(string $name): self
    {
        return $this->where($name, '[a-z\-0-9]+');
    }





    /**
     * @param string $name
     * @return $this
     */
    public function anything(string $name): self
    {
        return $this->where($name, '.*');
    }






    /**
     * Determine if route match current request method
    */
    public function matchRequestMethod(string $requestMethod): bool
    {
        return in_array($requestMethod, $this->methods);
    }








    /**
     * Determine if route match current request path
    */
    public function matchRequestPath(string $requestPath): bool
    {
        $requestUrl = $this->url($requestPath);
        $path       = $this->url(parse_url($requestPath, PHP_URL_PATH));
        $pattern    = $this->url($this->getPattern());

        if(preg_match("#^$pattern$#i", $path, $matches)) {
            $this->params  = $this->resolveParams($matches);
            $this->options(compact('requestPath', 'requestUrl'));
            return true;
        }

        return false;
    }








    /**
     * Determine if route match current request
    */
    public function match(string $method, string $path): bool
    {
        $matchedPath   = $this->matchRequestPath($path);
        $matchedMethod = $this->matchRequestMethod($method);

        if ($matchedPath && !$matchedMethod) {
             $this->createAllowedMethodsException($path);
        }

        return $matchedPath && $matchedMethod;
    }








    /**
     * @inheritDoc
     */
    public function generateUri(array $parameters = []): string
    {
        $path = $this->getPath();

        foreach ($parameters as $name => $value) {
            if (! empty(self::$wheres[$name])) {
                $path = preg_replace(array_keys(self::$wheres[$name]), [$value, $value], $path);
            }
        }

        return $path;
    }






    /**
     * @param array $parameters
     *
     * @return string
    */
    public function generateUrl(array $parameters = []): string
    {
        return $this->url($this->generateUri($parameters));
    }






    /**
     * @param string $path
     *
     * @return string
    */
    public function url(string $path): string
    {
        return sprintf('%s%s', trim($this->domain, '/'), $path);
    }






    /**
     * @return bool
    */
    public function callable(): bool
    {
        return is_callable($this->action);
    }





    /**
     * @return mixed
    */
    public function callAction(): mixed
    {
        if (! $this->callable()) {
            return false;
        }

        return call_user_func_array($this->action, array_values($this->params));
    }







    /**
     * @inheritDoc
    */
    public function getDomain(): string
    {
        return $this->domain;
    }







    /**
     * @inheritDoc
    */
    public function getMethods(): array
    {
        return $this->methods;
    }




    /**
     * @param string $separator
     *
     * @return string
    */
    public function getMethod(string $separator = '|'): string
    {
        return join($separator, $this->methods);
    }






    /**
     * @inheritDoc
    */
    public function getPath(): string
    {
        return $this->path;
    }





    /**
     * @inheritdoc
    */
    public function getPattern(): string
    {
        return $this->pattern;
    }



    



    /**
     * @inheritDoc
    */
    public function getAction(): mixed
    {
        return $this->action;
    }








    /**
     * @inheritDoc
    */
    public function getName(): string
    {
        return $this->name;
    }







    /**
     * @inheritDoc
    */
    public function getParams(): array
    {
        return $this->params;
    }





    /**
     * @inheritDoc
    */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }





    /**
     * @inheritDoc
    */
    public function getOptions(): array
    {
        return $this->options;
    }






    /**
     * @return string|null
    */
    public function getController(): ?string
    {
        return $this->option('controller');
    }






    /**
     * @return string
    */
    public function getActionName(): string
    {
        if ($this->action instanceof Closure) {
            return 'Closure';
        }

        return $this->option('action', '');
    }








    /**
     * @return array
    */
    public function getMatches(): array
    {
        return $this->matches;
    }





    /**
     * @return array
    */
    public function getPatterns(): array
    {
        return $this->patterns;
    }








    /**
     * Determine if the given name exist in options
     *
     * @param string $name
     *
     * @return bool
    */
    public function hasOption(string $name): bool
    {
        return isset($this->options[$name]);
    }





    /**
     * Determine if controller defined.
     *
     * @return bool
    */
    public function hasController(): bool
    {
        return $this->hasOption('controller');
    }







    /**
     * @param string $name
     *
     * @param string $pattern
     *
     * @return array
    */
    private function makePatterns(string $name, string $pattern): array
    {
        $pattern  = str_replace('(', '(?:', $pattern);
        $patterns = [
            "#{{$name}}#" => "(?P<$name>$pattern)",
            "#{{$name}.?}#" => "?(?P<$name>$pattern)?"
        ];

        $searched = array_keys($patterns);
        $replaces = array_values($patterns);

        $this->pattern = preg_replace($searched, $replaces, $this->pattern);

        return $patterns;
    }




    /**
     * @param string $domain
     *
     * @return $this
    */
    private function domain(string $domain): static
    {
        $this->domain = rtrim($domain, '/');

        return $this;
    }






    /**
     * @param array|string $methods
     *
     * @return $this
    */
    private function methods(array|string $methods): static
    {
        if (is_string($methods)) {
            $methods = explode('|', $methods);
        }

        $this->methods = $methods;

        return $this;
    }







    /**
     * @param string $path
     *
     * @return $this
    */
    private function path(string $path): static
    {
         $this->path = sprintf('/%s', trim($path, '/'));

         return $this->pattern($this->path);
    }







    /**
     * @param string $pattern
     *
     * @return $this
    */
    private function pattern(string $pattern): static
    {
        $this->pattern = $pattern;

        return $this;
    }






    /**
     * @param mixed $action
     *
     * @return $this
    */
    private function action(mixed $action): static
    {
         if (is_array($action)) {
             $this->options(['controller' => $action[0], 'action' => $action[1] ?? '__invoke']);
         }

         $this->action = $action;

         return $this;
    }






    /**
     * @param string $name
     *
     * @return void
    */
    private function name(string $name): void
    {
        $this->name = $name;
    }







    /**
     * @param array $middlewares
     *
     * @return array
    */
    private function resolveMiddlewares(array $middlewares): array
    {
        return array_map(function ($middleware) {
            $named = array_key_exists($middleware, self::$middlewareStack);
            return $named ? self::$middlewareStack[$middleware] : $middleware;
        }, $middlewares);
    }





    /**
     * @param array $matches
     *
     * @return array
    */
    private function resolveParams(array $matches): array
    {
        return array_filter($matches, function ($key) {
            return ! is_numeric($key);
        }, ARRAY_FILTER_USE_KEY);
    }




    /**
     * @param string $requestPath
     *
     * @return void
    */
    private function createAllowedMethodsException(string $requestPath): void
    {
        (function () use ($requestPath) {
             throw new RouteException("Route $requestPath allowed methods: {$this->getMethod(',')}");
        })();
    }







    /**
     * @inheritDoc
    */
    public function offsetExists(mixed $offset)
    {
        return property_exists($this, $offset);
    }





    /**
     * @inheritDoc
    */
    public function offsetGet(mixed $offset)
    {
        if (! $this->offsetExists($offset)) {
            return false;
        }

        return $this->{$offset};
    }




    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value)
    {
        if ($this->offsetExists($offset)) {
            $this->{$offset} = $value;
        }
    }




    /**
     * @inheritDoc
    */
    public function offsetUnset(mixed $offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->{$offset});
        }
    }
}