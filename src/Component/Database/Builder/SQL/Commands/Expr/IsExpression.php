<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\Expr;


/**
 * @IsExpression
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\Expr
*/
interface IsExpression
{

    /**
     * @return string
    */
    public function __toString(): string;
}