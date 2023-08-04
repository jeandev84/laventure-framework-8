<?php
namespace Laventure\Component\Routing\Generator;


use Laventure\Component\Routing\RouterInterface;


/**
 * @UrlGenerator
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Routing\Generator
*/
class UrlGenerator implements UrlGeneratorInterface
{


    /**
     * @param RouterInterface $router
     *
     * @param array $queries
    */
    public function __construct(protected RouterInterface $router, protected array $queries = [])
    {
    }




    /**
     * @inheritDoc
    */
    public function generate(string $name, array $parameters = [], array $queries = [], string $fragment = null): string
    {
         $path = $this->generateUri($name, $parameters, $queries, $fragment);

         return sprintf('%s%s', rtrim($this->router->getDomain(), '/'), $path);
    }





    /**
     * @inheritDoc
    */
    public function generateUri(string $name, array $parameters = [], array $queries = [], string $fragment = null): string
    {
        if (! $path = $this->router->generate($name, $parameters)) {
            (function () use ($name) {
                throw new UrlGeneratorException("Could not found route named $name");
            })();
        }

        return sprintf('%s%s', $path, $this->buildQueriesParams($queries, $fragment));
    }






    /**
     * @param array $queries
     *
     * @param string|null $fragment
     *
     * @return string
    */
    private function buildQueriesParams(array $queries, string $fragment = null): string
    {
        $queries  = array_merge($this->queries, $queries);
        $qs       = ! empty($queries) ? '?' . http_build_query($queries) : '';
        $fragment = $fragment ? "#$fragment" : '';

        return sprintf('%s%s', $qs, $fragment);
    }

}