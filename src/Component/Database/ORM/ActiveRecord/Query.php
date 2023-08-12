<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\JoinType;
use Laventure\Component\Database\Builder\SQL\Commands\Expr\Expr;
use Laventure\Component\Database\Builder\SQL\SqlQueryBuilder;
use Laventure\Component\Database\Connection\ConnectionInterface;


/**
 * @Query
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\ORM\ActiveRecord
 */
class Query
{


    protected SqlQueryBuilder $builder;



    /**
     * @var string
    */
    protected string $table;





    /**
     * @var array
    */
    protected array $wheres = [
        'AND' => [],
        'OR'  => []
    ];




    /**
     * @var array
    */
    protected array $parameters = [];





    /**
     * @var array|string[]
    */
    private array $operators = [
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
     * @var Select
    */
    protected Select $selects;




    /**
     * @var Expr
    */
    protected Expr $expr;




    /**
     * @param ConnectionInterface $connection
     *
     * @param string $table
     *
     * @param string $classname
     *
     * @param string $alias
    */
    public function __construct(
        ConnectionInterface $connection,
        string $table,
        string $classname,
        string $alias = '',
    )
    {
          $this->builder    = new SqlQueryBuilder($connection);
          $this->expr       = new Expr();
          $this->table      = $table;
          $this->selects    = $this->builder->select();
          $this->selects->from($table, $alias);
          $this->selects->map($classname);
    }






    /**
     * @param array|string $selects
     *
     * @return $this
    */
    public function select(array|string $selects = ''): static
    {
         $selects = is_array($selects) ? join(', ', $selects) : $selects;

         return $this->addSelect($selects);
    }






    /**
     * @param string $table
     *
     * @param string $alias
     *
     * @return $this
    */
    public function from(string $table, string $alias = ''): static
    {
        $this->selects->from($table, $alias);

        return $this;
    }






    /**
     * @param string $selects
     *
     * @return $this
    */
    public function addSelect(string $selects): static
    {
        $this->selects->addSelect($selects);

        return $this;
    }






    /**
     * @param bool $distinct
     *
     * @return $this
    */
    public function distinct(bool $distinct): static
    {
         $this->selects->distinct($distinct);

         return $this;
    }





    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @param string $type
     *
     * @return $this
     */
    public function join(string $table, string $condition, string $type = JoinType::JOIN): static
    {
         $this->selects->join($table, $condition, $type);

         return $this;
    }






    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
    */
    public function leftJoin(string $table, string $condition): static
    {
         $this->selects->leftJoin($table, $condition);

         return $this;
    }





    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
    */
    public function rightJoin(string $table, string $condition): static
    {
        $this->selects->rightJoin($table, $condition);

        return $this;
    }






    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
    */
    public function fullJoin(string $table, string $condition): static
    {
        $this->selects->fullJoin($table, $condition);

        return $this;
    }





    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
    */
    public function innerJoin(string $table, string $condition): static
    {
        $this->selects->innerJoin($table, $condition);

        return $this;
    }






    /**
     * @param string $column
     *
     * @param string $direction
     *
     * @return $this
    */
    public function orderBy(string $column, string $direction = 'asc'): static
    {
        $this->selects->orderBy($column, $direction);

        return $this;
    }







    /**
     * @param string $column
     *
     * @return $this
    */
    public function groupBy(string $column): static
    {
        $this->selects->groupBy($column);

        return $this;
    }







    /**
     * @param string $condition
     *
     * @return $this
    */
    public function having(string $condition): static
    {
        $this->selects->having($condition);

        return $this;
    }





    /**
     * @param int $limit
     *
     * @return $this
    */
    public function limit(int $limit): static
    {
        $this->selects->limit($limit);

        return $this;
    }







    /**
     * @param int $offset
     *
     * @return $this
    */
    public function offset(int $offset): static
    {
        $this->selects->offset($offset);

        return $this;
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
    public function where(string $column, $value, string $operator = "="): static
    {
         return $this->andWhere($column, $value, $operator);
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
    public function andWhere(string $column, $value, string $operator = "="): static
    {
          return $this->criteria( $column, $value, $operator, "AND");
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
        return $this->criteria($column, $value, $operator, "OR");
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
         return $this->where($column, $expression, "LIKE :$column");
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
         return $this->where($column, $data, "IN :($column)");
    }







    /**
     * Returns last inserted id
     *
     * @param array $attributes
     *
     * @return int
    */
    public function create(array $attributes): int
    {
        return $this->builder->insert($this->table, $attributes)
                             ->execute();
    }







    /**
     * @param array $attributes
     *
     * @return false|int
    */
    public function update(array $attributes): false|int
    {
        return $this->builder->update($this->table, $attributes)
                             ->andWheres($this->andWheres())
                             ->orWheres($this->orWheres())
                             ->setParameters($this->parameters)
                             ->execute();
    }








    /**
     * @return bool
    */
    public function delete(): bool
    {
        return $this->builder->delete($this->table)
                             ->andWheres($this->andWheres())
                             ->orWheres($this->orWheres())
                             ->setParameters($this->parameters)
                             ->execute();
    }





    /**
     * @return array
    */
    public function get(): array
    {
         return $this->selectQueryBuilder()
                     ->fetch()
                     ->all();
    }






    /**
     * @return mixed
    */
    public function one(): mixed
    {
         return $this->selectQueryBuilder()
                     ->limit(1)
                     ->fetch()
                     ->one();
    }







    /**
     * @return mixed
    */
    public function first(): mixed
    {
        return $this->get()[0] ?? null;
    }





    /**
     * @param int $page
     *
     * @param int $limit
     *
     * @return array
    */
    public function paginate(int $page, int $limit): array
    {
         return $this->selectQueryBuilder()
                     ->getPaginatedQuery()
                     ->paginate($page, $limit);
    }







    /**
     * @return Select
    */
    private function selectQueryBuilder(): Select
    {
        return $this->selects->andWheres($this->andWheres())
                           ->orWheres($this->orWheres())
                          ->setParameters($this->parameters);
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
    private function criteria(string $column, $value, string $operator, string $operand): static
    {
          $condition = "$column $operator :$column";

          if (! in_array($operator, $this->operators)) {
              $condition = "$column $operator";
          }

          $this->wheres[$operand][] = $condition;

          $this->parameters[$column] = $value;

          return $this;
    }





    /**
     * @return array|array[]
    */
    private function wheres(): array
    {
        return $this->wheres;
    }






    /**
     * @return array
    */
    private function andWheres(): array
    {
         return $this->wheres['AND'];
    }





    /**
     * @return array
    */
    private function orWheres(): array
    {
        return $this->wheres['OR'];
    }
}