<?php
namespace Laventure\Component\Templating\Template;


/**
 * @Template
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Templating\Template
*/
class Template implements TemplateInterface
{


    /**
     * @var string
    */
    protected string $path;




    /**
     * @var string
    */
    protected string $cacheKey = '';




    /**
     * @var array
    */
    protected array $parameters = [];




    /**
     * @param string $path
     *
     * @param array $parameters
    */
    public function __construct(string $path, array $parameters = [])
    {
         $this->setPath($path);
         $this->setParameters($parameters);
    }







    /**
     * @param string $path
     *
     * @return $this
    */
    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }






    /**
     * @param array $parameters
     *
     * @return $this
    */
    public function setParameters(array $parameters): static
    {
        $this->parameters = array_merge($this->parameters, $parameters);

        return $this;
    }





    /**
     * @inheritDoc
    */
    public function exists(): bool
    {
       return file_exists($this->path);
    }




    /**
     * @inheritDoc
    */
    public function getPath(): string
    {
        return $this->path;
    }





    /**
     * @inheritDoc
    */
    public function getParameters(): array
    {
        return $this->parameters;
    }





    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
        if (! $this->exists()) {
            $this->abortIf("template path: $this->path does not exist.");
        }

        extract($this->parameters, EXTR_SKIP);
        ob_start();
        require_once realpath($this->path);
        return ob_get_clean();
    }






    /**
     * @param string $message
     *
     * @param int $code
     *
     * @return mixed
    */
    public function abortIf(string $message, int $code = 500): mixed
    {
         return (function () use ($message, $code) {
               throw new TemplateException($message, $code);
         })();
    }
}