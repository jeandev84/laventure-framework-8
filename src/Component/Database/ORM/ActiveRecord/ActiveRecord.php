<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


use Laventure\Component\Database\Builder\SQL\Commands\DML\Delete;
use Laventure\Component\Database\Builder\SQL\Commands\DML\Update;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Select;
use Laventure\Component\Database\Builder\SQL\JoinType;
use Laventure\Component\Database\Builder\SQL\SqlQueryBuilder;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Connection\Query\QueryResultInterface;
use Laventure\Component\Database\Manager;
use Laventure\Component\Database\ORM\ActiveRecord\Query\Builder\SelectBuilder;
use Laventure\Component\Database\ORM\ActiveRecord\Query\QueryBuilder;
use Laventure\Component\Database\ORM\Convertor\CamelConvertor;


/**
 * @inheritdoc
 */
abstract class ActiveRecord implements ActiveRecordInterface
{

    use CamelConvertor;


    /**
     * @var string
     */
    protected string $table = '';




    /**
     * @var string
    */
    protected string $alias = '';




    /**
     * @var string
     */
    protected static string $primaryKey = 'id';





    /**
     * @var string|null
     */
    protected ?string $connection = null;





    /**
     * ActiveRecord attributes
     *
     * @var array
     */
    protected array $attributes = [];




    /**
     * @var string[]
     */
    private array $selected = [];




    /**
     * @var bool
     */
    private ?bool $distinct = false;



    /**
     * @var array[]
    */
    private ?array $from = [];




    /**
     * @var string[]
     */
    private array $orderBy = [];




    /**
     * @var string[]
    */
    private array $joins = [];





    /**
     * @var array
    */
    private array $groupBy = [];




    /**
     * @var string[]
     */
    private array $having = [];





    /**
     * @var int
     */
    private int $offset = 0;




    /**s
     * @var int
     */
    private int $limit = 0;




    /**
     * @var array
     */
    private array $wheres = [
        'AND'   => [],
        'OR' => []
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
     * @var static
     */
    private static $instance;






    /**
     * ActiveRecord constructor
     */
    private function __construct() {}




    /**
     * @param string|null $selects
     *
     * @return static
    */
    public static function select(string $selects = null): static
    {
        return self::model()->addSelect($selects);
    }






    /**
     * @param string|null $selects
     *
     * @return $this
    */
    public function addSelect(string $selects = null): static
    {
        $model = self::model();
        $model->selected[] = $selects;
        return $model;
    }






    /**
     * @param bool $distinct
     *
     * @return $this
     */
    public function distinct(bool $distinct): static
    {
        $model = self::model();
        $model->distinct = $distinct;
        return $model;
    }





    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @param string|null $type
     *
     * @return $this
    */
    public function join(string $table, string $condition, string $type = null): static
    {
        $model = self::model();
        $model->joins[] = [$table, $condition, $type ?: JoinType::JOIN];
        return $model;
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
         return self::model()->join($table, $condition, JoinType::LEFT);
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
        return self::model()->join($table, $condition, JoinType::RIGHT);
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
        return self::model()->join($table, $condition, JoinType::INNER);
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
        return self::model()->join($table, $condition, JoinType::FULL);
    }






    /**
     * @param string $column
     *
     * @param string $direction
     *
     * @return static
    */
    public static function orderBy(string $column, string $direction = 'asc'): static
    {
        $model = self::model();
        $model->orderBy[] = "$column $direction";
        return $model;
    }






    /**
     * @param string $column
     *
     * @return $this
    */
    public function groupBy(string $column): static
    {
        $model = self::model();
        $model->groupBy[] = $column;
        return $model;
    }







    /**
     * @param string $condition
     *
     * @return $this
    */
    public function having(string $condition): static
    {
        $model = self::model();
        $model->having[] = $condition;
        return $model;
    }






    /**
     * @param int $limit
     *
     * @return $this
    */
    public function limit(int $limit): static
    {
        $model = self::model();
        $model->limit = $limit;
        return $model;
    }






    /**
     * @param int $offset
     *
     * @return $this
    */
    public function offset(int $offset): static
    {
        $model = self::model();
        $model->offset = $offset;
        return $model;
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
        return static::model()->andWhere($column, $value, $operator);
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
        return static::model()->where($column, $data, "IN :($column)");
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
        return static::model()->criteria("OR", $column, $value, $operator);
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
        return $this->criteria("AND", $column, $value, $operator);
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
     * @param string $operator
     *
     * @return bool
    */
    private function hasOperator(string $operator): bool
    {
        return in_array($operator, $this->operators);
    }






    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function find(int $id): mixed
    {
        return static::select()->where(self::getPrimaryKey(), $id)->one();
    }






    /**
     * @return array
    */
    public static function all(): array
    {
        return self::select()->get();
    }








    /**
     * @param array $attributes
     *
     * @return int|bool
     */
    public static function create(array $attributes): int|bool
    {
        return self::model()->createQueryBuilder()
                            ->create($attributes)
                            ->execute();
    }






    /**
     * @param array $attributes
     *
     * @return bool|int
     */
    public function update(array $attributes): bool|int
    {
        $qb = self::model()->createQueryBuilder()
                           ->update($attributes, [self::getPrimaryKey() => $this->getId()]);

        $qb =$this->addConditions($qb);

        return $qb->execute();
    }







    /**
     * @return array
     */
    public function get(): array
    {
         return $this->selectQuery()->all();
    }








    /**
     * @return mixed
    */
    public function one(): mixed
    {
         return $this->selectQuery()
                     ->one();
    }





    /**
     * @return QueryResultInterface
    */
    private function selectQuery(): QueryResultInterface
    {
        $qb = $this->createQueryBuilder()
                   ->select(join(', ', self::model()->selected))
                   ->from($this->getTable(), $this->getTableAlias())
                   ->distinct($this->distinct)
                   ->map($this->getClassName());

        $qb = $this->addConditions($qb);
        $qb = $this->addJoins($qb);

        return $qb->setParameters($this->parameters)
                  ->fetch();
    }


    /**
     * @param Select|Update|Delete $qb
     *
     * @param array $defaults
     *
     * @return Select|Update|Delete
    */
    private function addConditions(Select|Update|Delete $qb): Select|Update|Delete
    {
        $model = self::model();

        if ($model->hasConditions()) {
            foreach (self::model()->wheres['AND'] as $condition) {
                $qb->andWhere($condition);
            }
            foreach (self::model()->wheres['OR'] as $condition) {
                $qb->orWhere($condition);
            }
        } else {
           $qb->criteria([$model]);
        }

        return $qb;
    }





    /**
     * @return bool
    */
    private function hasConditions(): bool
    {
        $model = self::model();

        return $model->wheres['AND'] || $model->wheres['OR'];
    }







    /**
     * @param Select $qb
     *
     * @return Select
    */
    private function addJoins(Select $qb): Select
    {
         foreach (self::model()->joins as $joined) {
             [$table, $condition, $type] = $joined;
             $qb->join($table, $condition, $type);
         }

         return $qb;
    }







    /**
     * Save data
     *
     * @return int
     */
    public function save(): int
    {
        if (! $attributes = $this->mapAttributesToSave()) {
            throw new \RuntimeException("No attributes mapped for saving in : ". self::getClassName());
        }

        if ($id = $this->getId()) {
            $this->update($attributes);
        } else {
            $id = static::create($attributes);
        }

        return $id;
    }







    /**
     * @inheritDoc
    */
    public function delete(): bool
    {
        $qb = self::model()->createQueryBuilder()
                           ->delete([self::getPrimaryKey() => $this->getId()]);

        $qb = $this->addConditions($qb);

        return $qb->execute();
    }









    /**
     * @return Manager
     */
    protected function getManager(): Manager
    {
        if(! $database = Manager::instance()) {
            throw new \RuntimeException("No connection to database detected in : ". self::getClassName());
        }

        return $database;
    }






    /**
     * @return QueryBuilder
    */
    private function createQueryBuilder(): QueryBuilder
    {
        $manager    = $this->getManager();
        $connection = $manager->pdoConnection($this->connection);
        return new QueryBuilder($connection, $this->getTable());
    }








    /**
     * Return table columns
     *
     * @return array
     */
    protected function getColumnsFromTable(): array
    {
        return $this->getManager()
                   ->schema($this->connection)
                   ->getColumns(self::getTable());
    }






    /**
     * @param string $name
     *
     * @param $value
     *
     * @return $this
     */
    public function setAttribute(string $name, $value): static
    {
        $name = $this->camelCaseToUnderscore($name);

        $this->attributes[$name] = $value;

        return $this;
    }





    /**
     * Set attributes
     *
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes): static
    {
        foreach ($attributes as $column => $value) {
            $this->setAttribute($column, $value);
        }

        return $this;
    }






    /**
     * @param string $column
     * @return bool
     */
    public function hasAttribute(string $column): bool
    {
        return isset($this->attributes[$column]);
    }





    /**
     * Remove attribute
     *
     * @param string $column
     * @return void
     */
    public function removeAttribute(string $column): void
    {
        if ($this->hasAttribute($column)) {
            unset($this->attributes[$column]);
        }
    }






    /**
     * Get attribute
     *
     * @param string $column
     *
     * @param null $default
     *
     * @return mixed|null
     */
    public function getAttribute(string $column, $default = null): mixed
    {
        return $this->attributes[$column] ?? $default;
    }







    /**
     * @inheritdoc
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }





    /**
     * @param $field
     * @param $value
     */
    public function __set($field, $value)
    {
        $this->setAttribute($field, $value);
    }






    /**
     * @param $field
     * @return mixed
     */
    public function __get($field)
    {
        return $this->getAttribute($field);
    }





    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return $this->hasAttribute($offset);
    }



    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }



    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }




    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        $this->removeAttribute($offset);
    }







    /**
     * Returns id
     *
     * @return int
     */
    private function getId(): int
    {
        return $this->getAttribute(self::getPrimaryKey(), 0);
    }








    /**
     * @return string
     */
    private function getTableAlias(): string
    {
        return mb_substr($this->getTable(), 0, 1, "UTF-8");
    }






    /**
     * Returns class name
     *
     * @return string
    */
    private static function getClassName(): string
    {
        return get_called_class();
    }






    /**
     * @return string
    */
    protected function getPrimaryKey(): string
    {
        if (! self::$primaryKey) {
            throw new \RuntimeException("Could not find primary key in : ". self::getClassName());
        }

        return self::$primaryKey;
    }





    /**
     * @return string
    */
    protected function getTable(): string
    {
        if (!$this->table) {
            throw new \RuntimeException("Could not detected model ". self::getClassName() . " table name.");
        }

        return $this->table;
    }






    /**
     * @return static
     */
    private static function model(): static
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
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
    private function criteria(string $operand, string $column, $value, string $operator = "="): static
    {
        $instance = self::model();

        $condition = "$column $operator :$column";

        if (! $instance->hasOperator($operator)) {
            $condition = "$column $operator";
        }

        $instance->wheres[$operand][] = $condition;

        $instance->parameters[$column] = $value;

        return $instance;
    }






    /**
     * Map attributes to save
     *
     * @return array
     */
    abstract protected function mapAttributesToSave(): array;
}