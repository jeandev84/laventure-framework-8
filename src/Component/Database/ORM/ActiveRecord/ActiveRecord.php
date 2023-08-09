<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract\SelectQueryInterface;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Query;
use Laventure\Component\Database\Manager;



/**
 * @inheritdoc
 */
abstract class ActiveRecord implements ActiveRecordInterface, \ArrayAccess
{
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
     * Store attributes we can save
     *
     * @var array
     */
    protected array $fillable = [];







    /**
     * Guard columns
     *
     * @var string[]
     */
    protected array $guarded = ['id'];




    private static $selected = [
        'selects'  => [],
        'distinct' => false
    ];




    /**
     * @var array
     */
    protected array $selects = [];




    /**
     * @var bool
     */
    protected bool $distinct = false;





    /**
     * @var array
     */
    protected array $joins = [];





    /**
     * @var array
     */
    protected array $wheres = [];





    /**
     * @var array
     */
    protected array $orderBy = [];





    /**
     * @var array
     */
    protected array $groupBy = [];




    /**
     * @var array
     */
    protected array $having = [];





    /**
     * @var array
     */
    protected array $parameters = [];





    /**
     * @var int
     */
    protected int $limit = 0;




    /**
     * @var int
     */
    protected int $offset = 0;






    /**
     * @var array|string[]
     */
    protected array $operators = [
        '='         => '',
        '>'         => '>',
        '<'         => '<',
        'like'      => 'LIKE',
        'in'        => 'IN',
        'not'       => 'NOT',
        'notLike'   => 'NOT LIKE'
    ];





    /**
     * @var static
     */
    protected static $model;





    private function __construct() {}





    /**
     * @return static
     */
    private static function instance(): static
    {
        if (! self::$model) {
            self::$model = new static();
        }

        return self::$model;
    }




    /**
     * @param string|null $selects
     *
     * @return $this
     */
    public static function select(string $selects = null): static
    {
        static::instance()->selects[] = $selects;

        return static::instance();
    }





    /**
     * @param bool $distinct
     *
     * @return $this
    */
    public function distinct(bool $distinct): static
    {
        static::instance()->distinct = $distinct;

        return static::instance();
    }






    /**
     * @param string $selects
     *
     * @return $this
    */
    public function addSelect(string $selects): static
    {
        static::instance()->selects[] = $selects;

        return static::instance();
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
    public function join(string $table, string $condition, string $type = 'JOIN'): static
    {
        self::instance()->joins[$table] = compact($condition, $type);

        return self::instance();
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
        return $this->join($table, $condition, 'LEFT');
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
        return $this->join($table, $condition, 'RIGHT');
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
        return $this->join($table, $condition, 'INNER');
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
        return $this->join($table, $condition, 'FULL');
    }









    /**
     * @param string $column
     *
     * @param string $direction
     *
     * @return $this
     */
    public static function orderBy(string $column, string $direction = 'asc'): static
    {
        static::instance()->orderBy[] = "$column $direction";

        return static::instance();
    }








    /**
     * @param string $column
     *
     * @return $this
    */
    public function groupBy(string $column): static
    {
        static::instance()->groupBy[] = $column;

        return static::instance();
    }











    /**
     * @param string $condition
     *
     * @return $this
     */
    public function having(string $condition): static
    {
        static::instance()->having[] = $condition;

        return static::instance();
    }









    /**
     * @param int $limit
     *
     * @return $this
    */
    public function limit(int $limit): static
    {
        static::instance()->limit = $limit;

        return static::instance();
    }








    /**
     * @param int $offset
     *
     * @return $this
     */
    public function offset(int $offset): static
    {
        static::instance()->offset = $offset;

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
    public static function where(string $column, $value, string $operator = '='): static
    {
        $binding = is_array($value) ? "(:$column)" : ":$column";

        static::instance()->wheres[$column]   = "$column $operator $binding";
        static::instance()->parameters[$column] = $value;

        return static::instance();
    }









    /**
     * @param string $column
     *
     * @param array $value
     *
     * @return $this
     */
    public static function whereIn(string $column, array $value): static
    {
        return static::where($column, $value, "IN :($column)");
    }







    /**
     * @param string $column
     *
     * @param $value
     *
     * @return $this
     */
    public static function whereLike(string $column, $value): static
    {
        return static::where($column, $value, "LIKE :($column)");
    }







    /**
     * @return array
     */
    public function get(): array
    {
        return $this->getQuery()->getResult();
    }






    /**
     * @return mixed
     */
    public function one(): mixed
    {
        return $this->getQuery()->getOneOrNullResult();
    }









    /**
     * @inheritDoc
     */
    public function delete(): bool
    {

    }






    /**
     * @inheritDoc
     */
    public function save(): int
    {
        $attributes = $this->mapAttributes();

        if ($id = $this->getId()) {
            $this->update($attributes);
        } else {
            $id = static::create($attributes);
        }
        return $id;
    }





    /**
     * @param array $attributes
     *
     * @return int
     */
    public function update(array $attributes): int
    {
        $criteria = [self::$primaryKey => $this->getId()];

        return $this->createQueryBuilder()
                    ->update($this->getTable(), $attributes, $criteria);
    }





    /**
     * @param array $attributes
     *
     * @return int
    */
    public static function create(array $attributes): int
    {
        $model = self::instance();

        return $model->createQueryBuilder()->insert($model->getTable(), $attributes);
    }








    /**
     * @inheritDoc
     */
    public static function find(int $id): false|static
    {
        return self::select()->where(self::$primaryKey, $id)->one();
    }








    /**
     * @inheritDoc
     */
    public static function findAll(): array
    {
        return self::select()->get();
    }







    /**
     * @return Manager
     */
    private static function getManager(): Manager
    {
        if(! $database = Manager::instance()) {
            throw new \RuntimeException("No connection to database detected in : ". get_called_class());
        }

        return $database;
    }








    /**
     * @return Builder
     */
    private function createQueryBuilder(): Builder
    {
        $database = static::getManager();

        return new Builder($database->pdoConnection($this->connection));
    }







    /**
     * @return Query
     */
    private function getQuery(): Query
    {
        if (! self::$model) {
            throw new \RuntimeException("no selection detected inside: ". $this->getClassName());
        }

        $selects = join(', ', self::$model->selects);

        return $this->createQueryBuilder()
            ->select($selects ?: null)
            ->from($this->getTable(), $this->getTableAlias())
            ->map(get_called_class())
            ->addJoins(self::$model->joins)
            ->wheres(self::$model->wheres)
            ->setParameters(self::$model->parameters)
            ->addGroupBy(self::$model->groupBy)
            ->limit(self::$model->offset)
            ->offset(self::$model->offset)
            ->getQuery();
    }








    /**
     * @return string
     */
    private function getTableAlias(): string
    {
        if ($this->alias) {
            return $this->alias;
        }

        return mb_substr($this->getTable(), 0, 1, "UTF-8");
    }






    /**
     * @return array
    */
    private function getColumnsFromTable(): array
    {
        return $this->getManager()
                    ->schema($this->connection)
                    ->getColumns($this->getTable());
    }





    /**
     * @return string
     */
    private function getClassName(): string
    {
        return get_called_class();
    }





    /**
     * @return string
     */
    protected function getTable(): string
    {
        if (! $this->table) {
            throw new \RuntimeException("Could not detected model ". get_class($this) . " table name.");
        }

        return $this->table;
    }






    /**
     * @return array
    */
    private function mapAttributes(): array
    {
        $attributes = [];

        $columns = $this->getColumnsFromTable();

        foreach ($columns as $column) {
            if (! empty($this->fillable)) {
                if (\in_array($column, $this->fillable)) {
                    $attributes[$column] = $this->{$column};
                }
            } else {
                $attributes[$column] = $this->{$column};
            }
        }

        if (! empty($this->guarded)) {
            foreach ($this->guarded as $guarded) {
                if (isset($attributes[$guarded])) {
                    unset($attributes[$guarded]);
                }
            }
        }

        return $attributes;
    }


    /**
     * @return int|null
     */
    private function getId(): ?int
    {
        return $this->getAttribute(self::$primaryKey);
    }







    /**
     * @param string $name
     *
     * @param $value
     *
     * @return $this
     */
    public function setAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;

        return $this;
    }




    /**
     * Set attributes
     *
     * @param array $attributes
     * @return void
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $column => $value) {
            $this->setAttribute($column, $value);
        }
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
    public function removeAttribute(string $column)
    {
        unset($this->attributes[$column]);
    }




    /**
     * Get attribute
     *
     * @param string $column
     * @return mixed|null
     */
    public function getAttribute(string $column)
    {
        return $this->attributes[$column] ?? null;
    }





    /**
     * @return array
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
}