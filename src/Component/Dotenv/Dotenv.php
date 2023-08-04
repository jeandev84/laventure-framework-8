<?php
namespace Laventure\Component\Dotenv;


/**
 * @Dotenv
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Dotenv
*/
class Dotenv
{

    /**
     * @var string
    */
    private string $root;



    /**
     * @param string $root
    */
    public function __construct(string $root)
    {
        $this->root = $root;
    }




    /**
     * @param string $root
     *
     * @return static
    */
    public static function create(string $root): static
    {
         return new static($root);
    }




    /**
     * @param string $filename
     * @return void
    */
    public function load(string $filename = '.env'): void
    {
        foreach ($this->getParams($filename) as $env) {
            $this->put($env);
        }
    }






    /**
     * @param string $filename
     *
     * @return bool
    */
    public function export(string $filename = '.env.local'): bool
    {
        if (! touch($filename) || empty($_ENV)) { return false; }

        foreach ($_ENV as $name => $value) {
            file_put_contents($filename, "$name=$value". PHP_EOL, FILE_APPEND);
        }

        return true;
    }





    /**
     * @param string $filename
     *
     * @return array
    */
    private function getParams(string $filename): array
    {
        if(! $path = realpath($this->locateFile($filename))){
            return [];
        }

        if(! $params = file($path, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES)) {
            return [];
        }

        return $this->filterParams($params);
    }




    /**
     * @param string $env
     *
     * @return $this
    */
    public function put(string $env): static
    {
        if (preg_match('#^(?=[A-Z])(.*)=(.*)$#', $env, $matches)) {

            putenv($env);

            [$key, $value] = $this->resolveParams($matches);

            $_SERVER[$key] = $_ENV[$key] = $value;

        }

        return $this;
    }




    /**
     * @param string $filename
     * @return string
    */
    private function locateFile(string $filename): string
    {
        return $this->root . DIRECTORY_SEPARATOR . trim($filename, DIRECTORY_SEPARATOR);
    }





    /**
     * @param array $matches
     *
     * @return string[]
    */
    private function resolveParams(array $matches): array
    {
        $parameters = str_replace(' ', '', trim($matches[0]));

        return explode("=", $parameters, 2);
    }





    /**
     * @param array $params
     *
     * @return array
    */
    private function filterParams(array $params): array
    {
        return array_filter($params, function ($value) {
            return stripos($value, '#') === false;
        });
    }
}