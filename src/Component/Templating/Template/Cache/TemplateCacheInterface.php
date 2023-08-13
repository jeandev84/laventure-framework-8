<?php
namespace Laventure\Component\Templating\Template\Cache;

use Laventure\Component\Templating\Template\TemplateInterface;

/**
 * @TemplateCacheInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Templating\Template\Caching
*/
interface TemplateCacheInterface
{

      /**
       * Returns cached path
       *
       * @param string $key
       *
       * @param TemplateInterface|string $template
       *
       * @return string
      */
      public function cache(string $key, TemplateInterface|string $template): string;

}