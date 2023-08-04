<?php



/**
 * @Autoloader
 *
 * @see https://www.php-fig.org/psr/psr-4/
 *
 * @see https://www.php-fig.org/psr/psr-4/examples/
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Foundation
*/
class Autoloader
{


     /**
      * @var string
     */
     protected string $root;



     /**
      * @var array
     */
     protected array $prefixes = [];



     /**
      * @param string $root
     */
     public function __construct(string $root)
     {
         $this->root = realpath(rtrim($root, DIRECTORY_SEPARATOR));
     }





     /**
      * @param string $namespace
      *
      * @param string $basePath
      *
      * @return $this
     */
     public function addNamespace(string $namespace, string $basePath): static
     {
          $this->prefixes[trim($namespace, '\\')] = $this->path($basePath);

          return $this;
     }





     /**
      * @return array
     */
     public function getNamespaces(): array
     {
         return $this->prefixes;
     }




     /**
      * @param array $namespaces
      *
      * @return $this
     */
     public function addNamespaces(array $namespaces): static
     {
          foreach ($namespaces as $prefix => $basePath) {
              $this->addNamespace($prefix, $basePath);
          }

          return $this;
     }




     /**
      * @param string $namespace
      *
      * @return bool
     */
     public function hasNamespace(string $namespace): bool
     {
         return array_key_exists($namespace, $this->prefixes);
     }




    /**
     * Register classes
    */
    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }





    /**
     * Unregister classes
    */
    public function unregister(): void
    {
        spl_autoload_unregister(function ($class) { });
    }



    /**
     * Autoload from file
     *
     * @param string $root
     *
     * @return void
    */
    public static function load(string $root): void
    {
         $autoloader = new static($root);
         $namespaces = $autoloader->loadJsonFile()['psr-4'] ?? [];
         $autoloader->addNamespaces($namespaces);
         $autoloader->register();
    }






     /**
      * @param string $class
      *
      * @return bool
     */
     public function loadClass(string $class): bool
     {
         $fragments = $this->getFragments($class);

         $prefix = array_shift($fragments);

         if (! $this->hasNamespace($prefix)) {
              return false;
         }

         $path = $this->buildPath($prefix, $fragments);

         if (! file_exists($path)) {
             return false;
         }

         require_once $path;
         return true;
     }





    /**
     * @param string $path
     *
     * @return string
    */
    private function normalizePath(string $path): string
    {
        return str_replace(["\\", "/"], DIRECTORY_SEPARATOR, trim($path, '\\/'));
    }




    /**
     * @param string $path
     *
     * @return string
    */
    private function path(string $path): string
    {
        return $this->root . DIRECTORY_SEPARATOR . $this->normalizePath($path);
    }




    /**
     * @param string $class
     * @return string[]
    */
    private function getFragments(string $class): array
    {
        return explode('\\', $class);
    }





    /**
     * @param string $prefix
     *
     * @param array $fragments
     *
     * @return string
    */
    private function buildPath(string $prefix, array $fragments): string
    {
        $classPath = join(DIRECTORY_SEPARATOR, $fragments) . '.php';

        return join(DIRECTORY_SEPARATOR, [$this->prefixes[$prefix], $classPath]);
    }





    /**
     * @return array
    */
    private function loadJsonFile(): array
    {
         $path = $this->path('laventure.json');

         if (! file_exists($path)) {
              return [];
         }


         return json_decode(file_get_contents($path), true);
    }

}