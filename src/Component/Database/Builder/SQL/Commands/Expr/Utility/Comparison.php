<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\Expr\Utility;



use Laventure\Component\Database\Builder\SQL\Commands\Expr\IsExpression;

/**
 * @Comparison
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\Expr\Utility
*/
class Comparison implements IsExpression
{


    /**
     * @var string
    */
    protected string $column;



    /**
     * @var string
    */
    protected string $operator;



    /**
     * @var mixed
    */
    protected mixed $value;





    /**
     * @param string $column
     *
     * @param string $operator
     *
     * @param mixed $value
    */
    public function __construct(string $column, string $operator, mixed $value)
    {
         $this->column = $column;
         $this->operator = $operator;
         $this->value = $value;
    }




    /**
     * @inheritdoc
    */
    public function __toString(): string
    {
        return sprintf('%s %s %s', $this->column, $this->operator, $this->value);
    }
}