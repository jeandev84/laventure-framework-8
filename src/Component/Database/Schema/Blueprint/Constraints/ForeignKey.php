<?php
namespace Laventure\Component\Database\Schema\Blueprint\Constraints;

use Laventure\Component\Database\Schema\Blueprint\Constraints\Contract\ConstraintInterface;



/**
 * @inheritdoc
*/
class ForeignKey implements ConstraintInterface
{

    /**
     * @var string
    */
    protected string $name;




    /**
     * @var string
    */
    protected string $column = '';





    /**
     * @var string
    */
    protected string $table = '';





    /**
     * @var string
    */
    protected string $constraintKey = '';




    /**
     * @var Constrained
    */
    protected Constrained $constrained;






    /**
     * @param string $name
     *
     * @param string $constraintKey
    */
    public function __construct(string $name, string $constraintKey = '')
    {
        $this->name = $name;
        $this->constraintKey = $constraintKey;
    }






    /**
     * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }






    /**
     * @return string
    */
    public function getConstraintKey(): string
    {
        return $this->constraintKey;
    }






    /**
     * @param string $column
     *
     * @return $this
     */
    public function references(string $column): static
    {
        $this->column = $column;

        return $this;
    }





    /**
     * @param string $table
     *
     * @return Constrained
    */
    public function on(string $table): Constrained
    {
        $this->table = $table;

        return $this->constrained();
    }







    /**
     * @return Constrained
     */
    public function constrained(): Constrained
    {
        return $this->constrained = new Constrained();
    }






    /**
     * @inheritDoc
    */
    public function __toString(): string
    {
        $format = [];

        if ($this->constraintKey) {
            $format[] = "CONSTRAINT {$this->constraintKey}";
        }

        $format[] = sprintf('FOREIGN KEY (%s) REFERENCES %s(%s)', $this->name, $this->table, $this->column);

        $format[] = $this->constrained;

        return join(' ', array_filter($format));
    }
}