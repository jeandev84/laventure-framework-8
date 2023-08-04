<?php
namespace Laventure\Component\Routing\Generator;

/**
 * @UrlGeneratorInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Routing\Generator
*/
interface UrlGeneratorInterface
{

    /**
     * Generate URL e.g /post/1?page=3&sort=name&direction=desc#target1
     *
     * @param string $name
     *
     * @param array $parameters
     *
     * @param array $queries
     *
     * @param string|null $fragment
     *
     * @return string
    */
    public function generate(string $name, array $parameters = [], array $queries = [], string $fragment = null): string;





    /**
     * @param string $name
     *
     * @param array $parameters
     *
     * @param array $queries
     *
     * @param string|null $fragment
     *
     * @return string
    */
    public function generateUri(string $name, array $parameters = [], array $queries = [], string $fragment = null): string;
}