<?php
namespace Laventure\Component\Database\Schema\Blueprint\Column;


/**
 * @ColumnInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Schema\Blueprint\Column
*/
interface ColumnInterface
{

    /**
     * Return column name
     *
     * @return string
    */
    public function getName(): string;




    /**
     * Returns column type
     *
     * @return string
    */
    public function getType(): string;







    /**
     * Returns column constraints
     *
     * @return string
    */
    public function getConstraints(): string;






    /**
     * Returns table comments
     *
     * @return string
    */
    public function getComments(): string;






    /**
     * Returns table encoding characters
     *
     * @return string
    */
    public function getCollation(): string;








    /**
     * @return bool
    */
    public function isPrimary(): bool;






    /**
     * @return string
    */
    public function __toString(): string;
}