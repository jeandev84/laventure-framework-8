<?php
namespace Laventure\Component\Database\Schema\Blueprint\Constraints;


/**
 * @Constrained
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Schema\Blueprint\Constraints
*/
class Constrained
{


    /**
     * @var array
    */
    protected array $constrained = [];






    /**
     * @param string|null $value
     * @return $this
    */
    public function onDelete(string $value = null): static
    {
        $this->constrained[] = sprintf('ON DELETE %s', $this->resolveValue($value));

        return $this;
    }






    /**
     * @param string|null $value
     *
     * @return $this
    */
    public function onUpdate(string $value = null): static
    {
        $this->constrained[] = sprintf('ON UPDATE %s', $this->resolveValue($value));

        return $this;
    }






    /**
     * @return string
    */
    public function __toString(): string
    {
        return join(' ', array_values($this->constrained));
    }






    /**
     * @param string|null $value
     *
     * @return string
    */
    private function resolveValue(string $value = null): string
    {
        return $value ? ucfirst($value) : 'SET NULL';
    }
}