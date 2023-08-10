<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\Builder\SQL\SqlQueryBuilder;
use Laventure\Component\Database\Manager;
use Laventure\Component\Database\ORM\ActiveRecord\Query\Builder\SelectBuilder;
use Laventure\Component\Database\ORM\ActiveRecord\Query\HasConditionInterface;
use Laventure\Component\Database\ORM\ActiveRecord\Query\QueryBuilder;


/**
 * @inheritdoc
*/
abstract class ActiveRecord implements ActiveRecordInterface
{

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
     * @var array
    */
    protected array $wheres = [];





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
     * @return SelectBuilder
    */
    public static function select(array|string $selects = null): SelectBuilder
    {
         return self::getQB()->select($selects);
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
    public static function where(string $column, $value, string $operator = '='): static
    {
          $instance = self::instance();
          $instance->wheres['wheres'][$column] = [$column, $value, $operator];
          return $instance;
    }




    /**
     * @param string $column
     *
     * @param array $data
     *
     * @return static
    */
    public static function whereIn(string $column, array $data): static
    {
        $instance = self::instance();
        $instance->wheres['whereIn'][$column] = [$column, $data];
        return $instance;
    }






    /**
     * @param string $column
     *
     * @param string $direction
     *
     * @return SelectBuilder
    */
    public static function orderBy(string $column, string $direction = 'asc'): SelectBuilder
    {
         return self::select()->orderBy($column, $direction);
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
        return self::getQB()->create($attributes)->execute();
    }






    /**
     * @param array $attributes
     *
     * @return bool|int
    */
    public function update(array $attributes): bool|int
    {
         return self::getQB()->update($attributes, [
             self::getPrimaryKey() => $this->getId()
         ])->execute();
    }






    /**
     * @return array
    */
    public function get(): array
    {
       $qb = self::select();
       $qb = $this->resolveConditions($qb);
       return $qb->get();
    }






    /**
     * @return mixed
    */
    public function one(): mixed
    {
        $qb = self::select();
        $qb = $this->resolveConditions($qb);
        return $qb->one();
    }





    /**
     * @param SelectBuilder $qb
     *
     * @return SelectBuilder
    */
    private function resolveConditions(SelectBuilder $qb): SelectBuilder
    {
        $instance = self::instance();
        foreach ($instance->wheres['wheres'] as $wheres) {
            [$column, $value, $operator] = $wheres;
            $qb->where($column, $value, $operator);
        }

        foreach ($instance->wheres['whereIn'] as $whereIn) {
            [$column, $data] = $whereIn;
            $qb->whereIn($column, $data);
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
         return self::getQB()->delete([
             self::getPrimaryKey() => $this->getId()
         ]);
    }







    /**
     * @return static
    */
    private static function instance(): static
    {
        if (! self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
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
    private static function getQB(): QueryBuilder
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
    public function setAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;

        return $this;
    }





    /**
     * Set attributes
     *
     * @param array $attributes
     *
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
     * Map attributes to save
     *
     * @return array
    */
    abstract protected function mapAttributes(): array;
}