<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


use Laventure\Component\Database\Builder\SQL\SqlQueryBuilder;
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
    protected static $table = '';





    /**
     * @var string
    */
    protected static string $primaryKey = 'id';





    /**
     * @var string|null
    */
    protected static ?string $connection = null;





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
    private bool $distinct = false;



    /**
     * @var array
    */
    private array $from = [];




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
        'WHERE' => []
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
     * @param array|string|null $selects
     *
     * @return static
     */
    public static function select(array|string $selects = null): static
    {
         dd(self::instance());
         return self::instance()->addSelect($selects);
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
        $model = self::instance();
        $model->from[$table] = $alias;
        return $model;
    }






    /**
     * @param array|string|null $selects
     *
     * @return $this
    */
    public function addSelect(array|string $selects = null): static
    {
        $model = self::instance();
        $model->selected[] = array($selects) ? join(', ', $selects) : $selects;
        return $model;
    }





    /**
     * @param string $table
     *
     * @param string $condition
     *
     * @return $this
     */
    public function join(string $table, string $condition): static
    {
        $model = self::instance();
        $model->joins['JOIN'][$table] = $condition;
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
        $model = self::instance();
        $model->joins['LEFT'][$table] = $condition;
        return $model;
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
        $model = self::instance();
        $model->joins['RIGHT'][$table] = $condition;
        return $model;
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
        $model = self::instance();
        $model->joins['INNER'][$table] = $condition;
        return $model;
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
        $model = self::instance();
        $model->joins['FULL'][$table] = $condition;
        return $model;
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
        $model = self::instance();
        $model->orderBy[$column] = $direction;
        return $model;
    }






    /**
     * @param string $column
     *
     * @return $this
    */
    public function groupBy(string $column): static
    {
        $model = self::instance();
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
        $model = self::instance();
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
        $model = self::instance();
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
        $model = self::instance();
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
        return self::query()->create($attributes)->execute();
    }






    /**
     * @param array $attributes
     *
     * @return bool|int
     */
    public function update(array $attributes): bool|int
    {
        $qb = self::query()->update($attributes, [
            self::getPrimaryKey() => $this->getId()
        ]);

        $qb = $qb->wheres($this->getWheres())
                 ->wheresIn($this->getWheresIn())
                 ->wheresLike($this->getWheresLike());

        return $qb->execute();
    }







    /**
     * @return array
    */
    public function get(): array
    {
        dd(self::instance());
        //return $this->selectQuery()->get();
    }








    /**
     * @return mixed
     */
    public function one(): mixed
    {
//        return $this->selectQuery()->one();
    }







    /**
     * @return SelectBuilder
     */
    private function selectQuery(): SelectBuilder
    {
//        $qb = self::select();
//        return $qb->wheres($this->getWheres())
//            ->wheresIn($this->getWheresIn())
//            ->wheresLike($this->getWheresLike());
    }









    /**
     * Save data
     *
     * @return int
     */
    public function save(): int
    {
        if (! $attributes = $this->mapAttributes()) {
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
        $qb = self::query()->delete([self::getPrimaryKey() => $this->getId()]);

//        return $qb->wheres($this->getWheres())
//            ->wheresIn($this->getWheresIn())
//            ->wheresLike($this->getWheresLike())
//            ->execute();
    }









    /**
     * @return Manager
     */
    protected static function getDB(): Manager
    {
        if(! $database = Manager::instance()) {
            throw new \RuntimeException("No connection to database detected in : ". self::getClassName());
        }

        return $database;
    }






    /**
     * @return QueryBuilder
     */
    private static function query(): QueryBuilder
    {
        $manager   = self::getDB();
        $builder   = new SqlQueryBuilder($manager->pdoConnection(self::$connection));
        return new QueryBuilder($builder, static::getTableName(), self::getClassName(), self::getTableAlias());
    }







    /**
     * Return table columns
     *
     * @return array
     */
    protected function getColumnsFromTable(): array
    {
        return $this->getDB()
            ->schema(self::$connection)
            ->getColumns(self::getTableName());
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
    private static function getTableAlias(): string
    {
        return mb_substr(static::getTableName(), 0, 1, "UTF-8");
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
    protected static function getPrimaryKey(): string
    {
        if (! self::$primaryKey) {
            throw new \RuntimeException("Could not find primary key in : ". self::getClassName());
        }

        return self::$primaryKey;
    }





    /**
     * @return string
    */
    protected static function getTableName(): string
    {
        if (! static::$table) {
            throw new \RuntimeException("Could not detected model ". self::getClassName() . " table name.");
        }

        return static::$table;
    }





    /**
     * @return array
     */
    private function getWheres(): array
    {
        return array_values(self::instance()->wheres['AND']);
    }





    /**
     * @return array
    */
    private function getWheresIn(): array
    {
        return array_values(self::instance()->wheres['IN']);
    }





    /**
     * @return array
    */
    private function getWheresLike(): array
    {
        return array_values(self::instance()->wheres['LIKE']);
    }






    /**
     * @return static
    */
    protected static function instance(): static
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }






    /**
     * Map attributes to save
     *
     * @return array
     */
    abstract protected function mapAttributes(): array;
}