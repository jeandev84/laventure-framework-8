<?php
namespace Laventure\Component\Templating\Mapper;


/**
 * @AssetMapperInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Templating\Mapper
*/
interface AssetMapperInterface
{


       /**
        * @param string $path
        *
        * @return string
       */
       public function loadResource(string $path): string;






       /**
        * Returns styles
        *
        * @return array
       */
       public function getStyles(): array;






       /**
        * @return string
       */
       public function renderStyles(): string;






       /**
        * Return scripts
        *
        * @return array
       */
       public function getScripts(): array;





       /**
        * @return string
       */
       public function renderScripts(): string;
}