<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\Expr;


use Laventure\Component\Database\Builder\SQL\Commands\Expr\Utility\andX;
use Laventure\Component\Database\Builder\SQL\Commands\Expr\Utility\Comparison;
use Laventure\Component\Database\Builder\SQL\Commands\Expr\Utility\Func;
use Laventure\Component\Database\Builder\SQL\Commands\Expr\Utility\Math;
use Laventure\Component\Database\Builder\SQL\Commands\Expr\Utility\orX;

/**
 * @Expr
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Builder\SQL\Commands\Expr\Expr
*/
class Expr
{

    /**
     * @param string ...$conditions
     *
     * @return andX
    */
    public function andX(string ...$conditions): andX
    {
        return new andX($conditions);
    }




    /**
     * @param string ...$conditions
     *
     * @return orX
    */
    public function orX(string ...$conditions): orX
    {
         return new orX($conditions);
    }




    /**
     * @param string $column
     *
     * @param $value
     *
     * @return Comparison
    */
    public function eq(string $column, $value): Comparison
    {
        return new Comparison($column, "=", $value);
    }




    /**
     * @param string $column
     *
     * @return string
    */
    public function isNull(string $column): string
    {
        return "$column IS NULL";
    }





    /**
     * @param string $column
     *
     * @return string
    */
    public function isNotNull(string $column): string
    {
        return "$column IS NOT NULL";
    }





    /**
     * @param string $column
     *
     * @param string $instance
     *
     * @return Comparison
    */
    public function isMemberOf(string $instance, string $column): Comparison
    {
        return new Comparison($instance,  "MEMBER OF", $column);
    }






    /**
     * @param string $column
     *
     * @param string $class
     *
     * @return Comparison
    */
    public function isInstanceOf(string $column, string $class): Comparison
    {
         return new Comparison($column, "INSTANCE OF", $class);
    }






    /**
     * @param string $x
     *
     * @param string $y
     *
     * @return Math
    */
    public function prod(string $x, string $y): Math
    {
        return new Math($x, "*", $y);
    }





    /**
     * @param string $x
     *
     * @param string $y
     *
     * @return Math
    */
    public function diff(string $x, string $y): Math
    {
        return new Math($x, "-", $y);
    }







    /**
     * @param string $x
     *
     * @param string $y
     *
     * @return Math
    */
    public function sum(string $x, string $y): Math
    {
        return new Math($x, "+", $y);
    }




    /**
     * @param string $x
     *
     * @param string $y
     *
     * @return Math
    */
    public function quot(string $x, string $y): Math
    {
         return new Math($x, "/", $y);
    }






    /**
     * @param string $column
     *
     * @param string|array $value
     *
     * @return Func
    */
    public function in(string $column, string|array $value): Func
    {
        $value = is_array($value) ? '(' . join(', ', $value) . ')' : $value;

        return new Func("$column IN $value");
    }






    /**
     * @param string $condition
     *
     * @return Func
    */
    public function not(string $condition): Func
    {
         return new Func("NOT $condition");
    }




    /**
     * @param string $column
     *
     * @param string|array $value
     *
     * @return Func
    */
    public function notIn(string $column, string|array $value): Func
    {
        return $this->not($this->in($column, $value));
    }






    /**
     * @param string $column
     *
     * @param string $value
     *
     * @return Func
     */
    public function like(string $column, string $value): Func
    {
        return new Func("$column LIKE $value");
    }






    /**
     * @param string $column
     *
     * @param string $value
     *
     * @return Func
    */
    public function notLike(string $column, string $value): Func
    {
        return $this->not($this->like($column, $value));
    }





    /**
     * @param string $column
     *
     * @param mixed $start
     *
     * @param mixed $end
     *
     * @return Func
    */
    public function between(string $column, mixed $start, mixed $end): Func
    {
        return new Func("$column BETWEEN $start AND $end");
    }






    /**
     * @param string $column
     *
     * @return Func
    */
    public function min(string $column): Func
    {
         return new Func("MIN($column)");
    }





    /**
     * @param string $column
     *
     * @return Func
    */
    public function max(string $column): Func
    {
        return new Func("MAX($column)");
    }






    /**
     * @param string $column
     *
     * @return Func
    */
    public function count(string $column): Func
    {
        return new Func("COUNT($column)");
    }






    /**
     * @param string $column
     *
     * @return Func
    */
    public function avg(string $column): Func
    {
        return new Func("AVG($column)");
    }




    /**
     * @param $column
     *
     * @return Func
    */
    public function abs($column): Func
    {
        return new Func("ABS($column)");
    }




    /**
     * @param $value
     *
     * @return Func
    */
    public function sqrt($value): Func
    {
         return new Func("SQRT($value)");
    }





    /**
     * @param $value
     *
     * @return Func
    */
    public function mod($value): Func
    {
         return new Func("MOD($value)");
    }







    /**
     * @param string $column
     *
     * @return Func
    */
    public function length(string $column): Func
    {
        return new Func("LEN($column)");
    }





    /**
     * @param string $column
     *
     * @return Func
    */
    public function countDistinct(string $column): Func
    {
        return new Func("COUNT (DISTINCT $column)");
    }




    /**
     * @param string $column
     *
     * @return Func
    */
    public function upper(string $column): Func
    {
        return new Func("UPPER($column)");
    }





    /**
     * @param string $column
     *
     * @return Func
    */
    public function lower(string $column): Func
    {
        return new Func("Lower($column)");
    }





    /**
     * @param string $column
     *
     * @param $from
     *
     * @param $len
     *
     * @return Func
     */
    public function substring(string $column, $from, $len): Func
    {
        return new Func("SUBSTRING($column, $from, $len)");
    }







    /**
     * @param string $column
     *
     * @return Func
    */
    public function concat(string $column): Func
    {
        return new Func("CONCAT($column)");
    }








    /**
     * @param string $value
     *
     * @return Func
    */
    public function trim(string $value): Func
    {
        return new Func("TRIM($value)");
    }





    /**
     * @param string $subQuery
     *
     * @return Func
    */
    public function exists(string $subQuery): Func
    {
        return new Func("EXIST $subQuery");
    }
}