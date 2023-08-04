<?php
namespace Laventure\Component\Templating\Template\Extension;

use Laventure\Component\Templating\Template\TemplateFilter;
use Laventure\Component\Templating\Template\TemplateFunction;


/**
 * @ExtensionInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Templating\Template\AbstractExtension
*/
interface ExtensionInterface
{

      /**
       * @return TemplateFunction[]
      */
      public function getFunctions(): array;



      /**
       * @return TemplateFilter[]
      */
      public function getFilters(): array;
}