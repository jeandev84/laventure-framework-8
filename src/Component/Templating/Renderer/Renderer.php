<?php
namespace Laventure\Component\Templating\Renderer;


use Laventure\Component\Templating\Template\Compressor\TemplateCompressor;
use Laventure\Component\Templating\Template\Engine\TemplateEngine;
use Laventure\Component\Templating\Template\Engine\TemplateEngineInterface;
use Laventure\Component\Templating\Template\Template;



/**
 * @Renderer
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Templating\Renderer
*/
class Renderer implements RendererInterface
{


      /**
       * @var TemplateEngineInterface
      */
      protected TemplateEngineInterface $engine;




      /**
       * Globals parameters
       *
       * @var array
      */
      protected array $data = [];





      /**
       * @param TemplateEngine $engine
      */
      public function __construct(TemplateEngineInterface $engine)
      {
           $this->engine = $engine;
      }








      /**
       * @param array $data
       *
       * @return $this
      */
      public function setGlobals(array $data): static
      {
          $this->data = array_merge($this->data, $data);

          return $this;
      }






      /**
       * @inheritDoc
      */
      public function render(string $path, array $data = []): string
      {
           return $this->engine->compile(new Template($path, array_merge($this->data, $data)));
      }
}