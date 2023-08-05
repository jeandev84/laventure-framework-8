<?php
namespace Laventure\Component\Database\Schema\Blueprint\Constraints\Contract;

/**
 * @ConstraintInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Schema\Blueprint\Constraints\Contract
*/
interface ConstraintInterface
{
    /**
     * @return string
    */
    public function __toString(): string;
}