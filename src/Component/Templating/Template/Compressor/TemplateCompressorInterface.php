<?php
namespace Laventure\Component\Templating\Template\Compressor;


/**
 * @TemplateCompressor
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Templating\Template\Caching
*/
interface TemplateCompressorInterface
{
       /**
        * @param string $template
        * @return string
       */
       public function compress(string $template): string;
}