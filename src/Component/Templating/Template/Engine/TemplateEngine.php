<?php
namespace Laventure\Component\Templating\Template\Engine;


use Laventure\Component\Templating\Template\Cache\TemplateCacheInterface;
use Laventure\Component\Templating\Template\Compressor\TemplateCompressor;
use Laventure\Component\Templating\Template\Template;
use Laventure\Component\Templating\Template\TemplateInterface;


/**
 * @TemplateEngine
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Templating\Template\Engine
*/
class TemplateEngine implements TemplateEngineInterface
{


    /**
     * @var string
    */
    protected string $resourcePath;




    /**
     * @var TemplateCacheInterface
    */
    protected TemplateCacheInterface $cache;




    /**
     * @var TemplateCompressor
    */
    protected TemplateCompressor $compressor;



    /**
     * @var bool
    */
    protected bool $compressed = false;



    /**
     * @var array
    */
    protected array $blocks = [];


    /**
     * @param string $resourcePath
     *
     * @param TemplateCacheInterface $cache
     *
     * @param bool $compressed
    */
    public function __construct(string $resourcePath, TemplateCacheInterface $cache, bool $compressed = false)
    {
        $this->resourcePath = $resourcePath;
        $this->cache        = $cache;
        $this->compressed   = $compressed;
        $this->compressor   = new TemplateCompressor();
    }






    /**
     * @param bool $compressed
     *
     * @return $this
    */
    public function compress(bool $compressed): static
    {
        $this->compressed = $compressed;

        return $this;
    }







    /**
     * @param string $resourcePath
     *
     * @return $this
    */
    public function resourcePath(string $resourcePath): static
    {
        $this->resourcePath = $resourcePath;

        return $this;
    }






    /**
     * @return string
    */
    public function getResourcePath(): string
    {
        return $this->resourcePath;
    }





    /**
     * @inheritDoc
    */
    public function compile(TemplateInterface $template): string
    {
         $content   = $this->includePaths($template);
         $content   = $this->compileBlocks($content);
         $content   = $this->compileYields($content);
         $content   = $this->compileEscapedEchos($content);
         $content   = $this->compileEchos($content);
         $content   = $this->compilePHP($content);
         $cachePath = $this->cache->cache($template->getCacheKey(), $content);
         $engine    = $this->createTemplate($cachePath, $template->getParameters());
         return $this->compressed ? $this->compressor->compress($engine) : $engine;
    }








    /**
     * @param string $path
     *
     * @param array $parameters
     *
     * @return Template
    */
    public function createTemplate(string $path, array $parameters = []): Template
    {
         return new Template($path, $parameters);
    }






    /**
     * @param TemplateInterface $template
     *
     * @return string
    */
    private function includePaths(TemplateInterface $template): string
    {
        $pattern = '/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i';
        $content = $this->content($template->getPath());

        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $value) {
            $included = $this->createTemplate($this->locateTemplate($value[2]));
            $content  = str_replace($value[0], $this->includePaths($included), $content);
        }

        return preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $content);
    }





    /**
     * @param string $content
     *
     * @return string
    */
    private function compileBlocks(string $content): string
    {
        $pattern = '/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is';

        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $value) {
             if (! array_key_exists($value[1], $this->blocks)) { $this->blocks[$value[1]] = ''; }
             if (str_contains($value[2], '@parent') === false) {
                 $this->blocks[$value[1]] = $value[2];
             } else {
                 $this->blocks[$value[1]] = str_replace('@parent', $this->blocks[$value[1]], $value[2]);
             }
             $content = str_replace($value[0], '', $content);
        }

        return $content;
    }





    /**
     * @param string $content
     *
     * @return string
    */
    private function compileYields(string $content): string
    {
         foreach ($this->blocks as $name => $value) {
             $content = preg_replace("/{% yield ?$name ?%}/", $value, $content);
         }

         return $content;
    }






    /**
     * @param string $content
     * @return string
    */
    private function compileEscapedEchos(string $content): string
    {
        return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $content);
    }




    /**
     * @param string $content
     *
     * @return string
    */
    private function compileEchos(string $content): string
    {
        return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $content);
    }




    /**
     * @param string $content
     *
     * @return string
    */
    private function compilePHP(string $content): string
    {
          $content = $this->compileLoop($content);
          $content = $this->compileIf($content);
          $content = $this->compileSwitch($content);
          return preg_replace('~\{%\s*(.+?)\s*\%}~is', '<?php $1 ?>', $content);
    }





    /**
     * @param string $content
     *
     * @return string
     */
    private function compileLoop(string $content): string
    {
        $content = preg_replace('/@loop?(.*):/i', '<?php foreach$1: ?>', $content);
        $content = preg_replace('/@endloop/', '<?php endforeach; ?>', $content);
        $content = preg_replace('/@for?(.*):/i', '<?php for$1: ?>', $content);
        return preg_replace('/@endfor/', '<?php endfor; ?>', $content);
    }





    /**
     * @param string $content
     *
     * @return string
     */
    private function compileSwitch(string $content): string
    {
        $content = preg_replace('/@switch?(.*):/', '<?php switch$1: ?>', $content);
        return preg_replace('/@endswitch/', '<?php endswitch; ?>', $content);
    }






    /**
     * @param string $content
     *
     * @return string
    */
    private function compileIf(string $content): string
    {
        $content = preg_replace('/@if(.*):/', '<?php if$1: ?>', $content);
        return preg_replace('/@endif/', '<?php endif; ?>', $content);
    }






    /**
     * @param string $path
     *
     * @return string
    */
    public function locateTemplate(string $path): string
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, trim($path, '/'));

        return rtrim($this->resourcePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $path;
    }







    /**
     * @param string $path
     *
     * @return string
    */
    private function content(string $path): string
    {
         if (! file_exists($path)) {
              return '';
         }

         return file_get_contents($path);
    }
}