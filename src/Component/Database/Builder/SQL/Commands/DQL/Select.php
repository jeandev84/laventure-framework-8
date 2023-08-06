<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;


use Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract\SelectBuilderInterface;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract\SelectQueryInterface;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Mapping\ObjectPersistenceInterface;
use Laventure\Component\Database\Builder\SQL\Commands\HasConditions;
use Laventure\Component\Database\Builder\SQL\Commands\SQLBuilderHasConditions;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Query\QueryResultInterface;



/**
 * @inheritdoc
*/
class Select extends SQLBuilderHasConditions implements SelectBuilderInterface
{


    use HasConditions;


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
     * @var ObjectPersistenceInterface
    */
    protected ObjectPersistenceInterface $persistence;





    /**
     * @param ConnectionInterface $connection
    */
    public function __construct(ConnectionInterface $connection)
    {
         parent::__construct($connection, '');
         $this->persistence = new ObjectPersistence();
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
     * @inheritDoc
    */
    public function distinct(bool $distinct): static
    {
        $this->distinct = $distinct;

        return $this;
    }






    /**
     * @inheritDoc
    */
    public function addSelect(string $select): static
    {
         $this->selected[] = $select;

         return $this;
    }





    /**
     * @inheritDoc
    */
    public function from(string $table, string $alias = ''): static
    {
         $this->from[$table] = $alias ? "$table $alias" : $table;

         return $this;
    }





    /**
     * @inheritDoc
    */
    public function orderBy(string $column, string $direction = 'asc'): static
    {
        return $this->addOrderBy(sprintf('%s %s', $column, strtoupper($direction)));
    }





    /**
     * @param string $orderBy
     *
     * @return $this
    */
    public function addOrderBy(string $orderBy): static
    {
         $this->orderBy[] = $orderBy;

         return $this;
    }





    /**
     * @inheritDoc
    */
    public function join(string $table, string $condition, string $type = null): static
    {
         $type = $type ? strtoupper($type). " JOIN" : "JOIN";

         $this->joins[] = sprintf('%s %s ON %s', $type, $table, $condition);

         return $this;
    }





    /**
     * @inheritdoc
    */
    public function innerJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "INNER");
    }






    /**
     * @inheritdoc
    */
    public function leftJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "LEFT");
    }






    /**
     * @inheritdoc
    */
    public function rightJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "RIGHT");
    }







    /**
     * @inheritdoc
    */
    public function fullJoin(string $table, string $condition): static
    {
        return $this->join($table, $condition, "FULL");
    }








    /**
     * @inheritDoc
    */
    public function groupBy(string $column): static
    {
        $this->groupBy[] = $column;

        return $this;
    }






    /**
     * @inheritDoc
    */
    public function having(string $condition): static
    {
        $this->having[] = $condition;

        return $this;
    }






    /**
     * @inheritDoc
    */
    public function limit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }




    /**
     * @inheritDoc
    */
    public function offset(int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }





    /**
     * @param string $classname
     *
     * @return $this
    */
    public function map(string $classname): static
    {
        $this->persistence->mapped($classname);

        return $this;
    }






    /**
     * @inheritDoc
    */
    public function fetch(): QueryResultInterface
    {
        $fetch = $this->statement()->fetch();

        if ($this->persistence->hasMapping()) {
            $fetch->map($this->persistence->getMapped());
        }

        return $fetch;
    }






    /**
     * @inheritdoc
    */
    public function getQuery(): SelectQueryInterface
    {
        return new Query($this->fetch(), $this->persistence);
    }





    /**
     * @inheritdoc
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