<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;


use Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence\NullObjectPersistence;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence\ObjectPersistenceInterface;
use Laventure\Component\Database\Builder\SQL\Commands\SQLBuilderHasConditions;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryResultInterface;



/**
 * @inheritdoc
*/
class Select extends SQLBuilderHasConditions
{


    use ClassMapping;



    /**
     * @var string[]
    */
    protected array $selected = [];



    /**
     * @var int
     */
    protected int $offset = 0;




    /**s
     * @var int
     */
    protected int $limit = 0;



    /**
     * @var bool
    */
    protected bool $distinct = false;



    /**
     * @var array
    */
    protected array $from = [];




    /**
     * @var string[]
    */
    protected array $orderBy = [];




    /**
     * @var string[]
    */
    protected array $joins = [];



    /**
     * @var array
    */
    protected array $groupBy = [];




    /**
     * @var string[]
    */
    protected array $having = [];





    /**
     * @var array|string[]
    */
    protected array $joinTypes = ['LEFT', 'RIGHT', 'FULL', 'INNER'];




    /**
     * @var ObjectPersistenceInterface
    */
    protected ObjectPersistenceInterface $persistence;





    /**
     * @param ConnectionInterface $connection
     *
     * @param string|null $selects
    */
    public function __construct(ConnectionInterface $connection, string $selects = null)
    {
         parent::__construct($connection, '');
         $this->persistence = new NullObjectPersistence();
         $this->addSelect($selects ?: "*");
    }





    /**
     * set object persistence manager
     *
     * @param ObjectPersistenceInterface $persistence
     *
     * @return $this
    */
    public function persistence(ObjectPersistenceInterface $persistence): static
    {
        $this->persistence = $persistence;

        return $this;
    }


    /**
     * @param bool $distinct
     *
     * @return $this
     */
    public function distinct(bool $distinct): static
    {
        $this->distinct = $distinct;

        return $this;
    }


    /**
     * @param string $select
     * @return $this
     */
    public function addSelect(string $select): static
    {
         $this->selected[] = $select;

         return $this;
    }


    /**
     * @param string $table
     * @param string $alias
     * @return $this
     */
    public function from(string $table, string $alias = ''): static
    {
         $this->from[$table] = $alias ? "$table $alias" : $table;

         return $this;
    }


    /**
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'asc'): static
    {
        $this->orderBy[] = sprintf('%s %s', $column, strtoupper($direction));

        return $this;
    }





    /**
     * @return $this
    */
    public function addOrderBy(array $orderBy): static
    {
         foreach ($orderBy as $column => $direction) {
             $this->orderBy($column, $direction);
         }

         return $this;
    }


    /**
     * @param string $table
     * @param string $condition
     * @param string|null $type
     * @return $this
     */
    public function join(string $table, string $condition, string $type = null): static
    {
          if ($type && ! in_array($type, $this->joinTypes)) {
              throw new \RuntimeException("Join table required types: ". join(", ", $this->joinTypes));
          }

          $type = $type ? "$type JOIN" : "JOIN";

         $this->joins[] = sprintf('%s %s ON %s', $type, $table, $condition);

         return $this;
    }





    /**
     * @param array $joins
     *
     * @return $this
    */
    public function addJoins(array $joins): static
    {
        foreach ($joins as $table => $joined) {
            [$condition, $type] = array_values($joined);
            $this->join($table, $condition, $type);
        }

        return $this;
    }


    /**
     * @param string $table
     * @param string $condition
     * @return $this
     */
    public function innerJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "INNER");
    }


    /**
     * @param string $table
     * @param string $condition
     * @return $this
     */
    public function leftJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "LEFT");
    }






    /**
     * @param string $table
     * @param string $condition
     * @return $this
    */
    public function rightJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "RIGHT");
    }





    /**
     * @param string $table
     * @param string $condition
     * @return $this
    */
    public function fullJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "FULL");
    }





    /**
     * @param string $column
     *
     * @return $this
    */
    public function groupBy(string $column): static
    {
        $this->groupBy[] = $column;

        return $this;
    }





    /**
     * @param array $columns
     *
     * @return $this
    */
    public function addGroupBy(array $columns): static
    {
        foreach ($columns as $column) {
            $this->groupBy($column);
        }

        return $this;
    }


    /**
     * @param string $condition
     * @return $this
     */
    public function having(string $condition): static
    {
        $this->having[] = $condition;

        return $this;
    }


    /**
     * @param int|null $limit
     * @return $this
     */
    public function limit(?int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }


    /**
     * @param int|null $offset
     * @return $this
    */
    public function offset(?int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }





    /**
     * @return QueryResultInterface
    */
    public function fetch(): QueryResultInterface
    {
         $fetch = $this->statement()
                       ->setParameters($this->parameters)
                       ->fetch();

         if ($this->mappedClass) {
              $fetch->map($this->mappedClass);
         }

         return $fetch;
    }



    /**
     * @return Query
    */
    public function getQuery(): Query
    {
        return new Query($this->fetch(), $this->persistence);
    }





    /**
     * @return ObjectPersistenceInterface
    */
    public function getPersistence(): ObjectPersistenceInterface
    {
        return $this->persistence;
    }






    /**
     * @inheritDoc
    */
    public function getSQL(): string
    {
         return $this->buildSelectSQL();
    }






    /**
     * @return string
    */
    public function getTable(): string
    {
        return join(', ', array_values($this->from));
    }





    /**
     * @return string
    */
    private function selectSQL(): string
    {
        $command   =  $this->distinct ? 'SELECT DISTINCT' : 'SELECT';
        $columns   =  empty($this->selected) ? "*" : join(', ', array_filter($this->selected));
        $selection =  join(' ', [$command, $columns]);

        return sprintf('%s FROM %s', $selection, $this->getTable());
    }






    /**
     * @return string
    */
    private function joinSQL(): string
    {
        return ($this->joins ? join(' ', $this->joins) : '');
    }





    /**
     * @return string
    */
    private function groupBySQL(): string
    {
         return ($this->groupBy ? sprintf('GROUP BY %s', join($this->groupBy)) : '');
    }





    /**
     * @return string
    */
    private function havingSQL(): string
    {
        return ($this->having ? sprintf('HAVING %s', join($this->having)) : '');
    }



    /**
     * @return string
    */
    private function orderBySQL(): string
    {
        return ($this->orderBy ? rtrim(sprintf('ORDER BY %s', join(',', $this->orderBy))) : '');
    }




    /**
     * @return string
    */
    private function limitSQL(): string
    {
        if (! $this->limit) {
            return '';
        }

        $limit = "LIMIT $this->limit";

        if ($this->offset) {
            return "$limit OFFSET $this->offset";
        }

        return $limit;
    }





    /**
     * @return string
    */
    private function buildSelectSQL(): string
    {
         return join(' ', array_filter([
             $this->selectSQL(),
             $this->joinSQL(),
             $this->whereSQL(),
             $this->groupBySQL(),
             $this->havingSQL(),
             $this->orderBySQL(),
             $this->limitSQL()
         ])) .';';
    }
}