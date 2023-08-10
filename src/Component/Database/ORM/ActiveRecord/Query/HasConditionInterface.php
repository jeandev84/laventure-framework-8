<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;


/**
 * @HasConditionInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\ActiveRecord\Query
*/
interface HasConditionInterface
{

     /**
      * @param string $column
      *
      * @param $value
      *
      * @param string $operator
      *
      * @return static
     */
     public static function where(string $column, $value, string $operator = "="): static;








     /**
      * @param string $column
      *
      * @param $value
      *
      * @return $this
     */
     public function andWhere(string $column, $value): static;






     /**
      * @param string $column
      *
      * @param $value
      *
      * @return $this
     */
     public function orWhere(string $column, $value): static;










    /**
     * @param string $column
     *
     * @param string $expression
     *
     * @return $this
    */
    public function whereLike(string $column, string $expression): static;







    /**
     * @param string $column
     *
     * @param array $data
     *
     * @return $this
    */
    public function whereIn(string $column, array $data): static;
}