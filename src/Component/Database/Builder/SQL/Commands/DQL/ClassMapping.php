<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence;



trait ClassMapping
{


    /**
     * @var string
    */
    protected string $mapped = '';





    /**
     * @param string $mapped
     *
     * @return static
    */
    public function mapped(string $mapped): static
    {
        $this->mapped = $mapped;

        return $this;
    }





    /**
     * @return bool
    */
    public function hasMapping(): bool
    {
        return ! empty($this->mapped);
    }






    /**
     * @return string
    */
    public function getMapped(): string
    {
        return $this->mapped;
    }
}