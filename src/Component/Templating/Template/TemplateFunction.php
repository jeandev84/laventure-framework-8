<?php
namespace Laventure\Component\Templating\Template;

class TemplateFunction
{

    /**
     * @var string
    */
    protected string $name;



    /**
     * @var array
    */
    protected array $callback;




    /**
     * @param string $name
     *
     * @param array $callback
    */
    public function __construct(string $name, array $callback)
    {
    }



    /**
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }



    /**
     * @return array
    */
    public function getCallback(): array
    {
        return $this->callback;
    }
}