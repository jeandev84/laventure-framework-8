<?php
namespace Laventure\Component\Templating\Template;

/**
 * @TemplateInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Templating\Template
*/
interface TemplateInterface
{



    /**
     * Returns path of template
     *
     * @return string
    */
    public function getPath(): string;




    /**
     * Returns template parameters
     *
     * @return array
    */
    public function getParameters(): array;





    /**
     * Determine if template path exists
     *
     * @return bool
    */
    public function exists(): bool;







    /**
     * Returns template content
     *
     * @return string
    */
    public function __toString(): string;
}