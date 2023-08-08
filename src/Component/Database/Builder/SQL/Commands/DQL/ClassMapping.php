<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;



trait ClassMapping
{


    /**
     * Class Mapping
     *
     * @var string
    */
    protected string $mappedClass;







    /**
     * Class mapping
     *
     * @param string $classname
     *
     * @return $this
    */
    public function map(string $classname): static
    {
        $this->mappedClass = $classname;

        return $this;
    }







    /**
     * @return bool
    */
    public function hasMapping(): bool
    {
        return ! empty($this->mappedClass);
    }







    /**
     * @return string
    */
    public function getMapped(): string
    {
        return $this->mappedClass;
    }
}