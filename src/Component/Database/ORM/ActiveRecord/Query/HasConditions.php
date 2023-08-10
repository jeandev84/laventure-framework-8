<?php
namespace Laventure\Component\Database\ORM\ActiveRecord\Query;


/**
 * @HasConditions
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\ActiveRecord\Query
 */
trait HasConditions
{


    /**
     * @var array
    */
    protected array $wheres = [
        'AND'  => [],
        'OR'   => [],
        'LIKE' => [],
        'not'  => [],
        'in'   => []
    ];




    /**
     * @var array
    */
    protected array $parameters = [];




    /**
     * @var array|string[]
    */
    protected array $operators = [
        '=',
        '>',
        '>=',
        '<',
        '>=',
        'LIKE',
        'OR',
        'NOT',
        'AND'
    ];




    /**
     * @var static
    */
    private static $instance;





    /**
     * @return static
    */
    protected static function instance(): static
    {
        if (self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }






    /**
     * @param string $column
     *
     * @param $value
     *
     * @param string $operator
     *
     * @return static
    */
    public static function where(string $column, $value, string $operator = "="): static
    {
        return static::instance()->andWhere($column, $value, $operator);
    }







    /**
     * @param string $column
     *
     * @param array $data
     *
     * @return $this
    */
    public function whereIn(string $column, array $data): static
    {
        return static::instance()->where($column, $data, "IN :($column)");
    }






    /**
     * @param array $wheres
     *
     * @return $this
    */
    public function wheresIn(array $wheres): static
    {
        foreach ($wheres as $whereIn) {
            [$column, $data] = $whereIn;
            return static::instance()->whereIn($column, $data);
        }

        return $this;
    }







    /**
     * @param string $column
     *
     * @param $value
     *
     * @param string $operator
     *
     * @return $this
    */
    public function orWhere(string $column, $value, string $operator = "="): static
    {
        return static::instance()->addCondition("OR", $column, $value, $operator);
    }







    /**
     * @param array $wheres
     *
     * @return $this
    */
    public function orWheres(array $wheres): static
    {
        foreach ($wheres as $orWheres) {
             [$column, $value, $operator] = $orWheres;
             static::instance()->orWhere($column, $value, $operator);
        }

        return static::instance();
    }




    /**
     * @param string $column
     *
     * @param $value
     *
     * @param string $operator
     *
     * @return $this
    */
    public function andWhere(string $column, $value, string $operator = '='): static
    {
        return $this->addCondition("AND", $column, $value, $operator);
    }







    /**
     * @param string $column
     *
     * @param string $expression
     *
     * @return $this
     */
    public function whereLike(string $column, string $expression): static
    {
        return $this->where($column, $expression, "LIKE");
    }









    /**
     * @param array $wheres
     *
     * @return $this
     */
    public function wheresLike(array $wheres): static
    {
        foreach ($wheres as $whereLike) {
            [$column, $expression] = $whereLike;
            $this->whereLike($column, $expression);
        }

        return $this;
    }





    /**
     * @param string $operator
     *
     * @return bool
    */
    private function hasOperator(string $operator): bool
    {
        return in_array($operator, $this->operators);
    }







    /**
     * @param string $operand
     *
     * @param string $column
     *
     * @param $value
     *
     * @param string $operator
     *
     * @return $this
    */
    private function addCondition(string $operand, string $column, $value, string $operator = "="): static
    {
        $instance = self::instance();

        $condition = "$column $operator :$column";

        if (! $instance->hasOperator($operator)) {
            $condition = "$column $operator";
        }

        $instance->wheres[$operand][$column] = $condition;

        $instance->parameters[$column] = $value;

        return $instance;
    }




    protected function getAndWheres(): array
    {
         $andWheres = self::instance()->wheres['AND'];
         $wheres = [];


    }
}