<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\Expr\Utility;


use Laventure\Component\Database\Builder\SQL\Commands\Expr\IsExpression;

/**
 * @orX
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\Expr\Utility
*/
class orX implements IsExpression
{

    /**
     * @var array
    */
    protected array $conditions = [];




    /**
     * @param array $conditions
    */
    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }






    /**
     * @inheritdoc
    */
    public function __toString(): string
    {
        return join(" OR ", $this->conditions);
    }
}