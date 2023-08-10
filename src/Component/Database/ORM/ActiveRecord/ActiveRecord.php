<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\Manager;
use Laventure\Component\Database\ORM\ActiveRecord\Query\Builder\SelectBuilder;



/**
 * @inheritdoc
*/
abstract class ActiveRecord implements ActiveRecordInterface
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
     * @var QueryBuilder
    */
    protected static QueryBuilder $qb;





    /**
     * ActiveRecord constructor
    */
    private function __construct()
    {
         $manager   = self::getManager();
         $builder   = new Builder($manager->pdoConnection($this->connection));
         self::$qb  = new QueryBuilder($builder, $this->getTable(), self::getClassName(), $this->alias);
    }





    /**
     * @param array|string|null $selects
     *
     * @return SelectBuilder
    */
    public static function select(array|string $selects = null): SelectBuilder
    {
         return self::$qb->select($selects);
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
        return self::$qb->insert($attributes);
    }






    /**
     * @param array $attributes
     *
     * @return bool|int
    */
    public function update(array $attributes): bool|int
    {
         return self::$qb->update($attributes, [self::getPrimaryKey() => $this->getId()]);
    }






    /**
     * @inheritDoc
    */
    public function delete(): bool
    {

    }





    /**
     * @return Manager
    */
    protected static function getManager(): Manager
    {
        if(! $database = Manager::instance()) {
            throw new \RuntimeException("No connection to database detected in : ". self::getClassName());
        }

        return $database;
    }





    /**
     * @return array
    */
    protected function getColumnsFromTable(): array
    {
        return $this->getManager()
                    ->schema($this->connection)
                    ->getColumns($this->getTable());
    }







    /**
     * @return string
    */
    private static function getClassName(): string
    {
        return get_called_class();
    }







    /**
     * @return string
    */
    protected function getTable(): string
    {
        if (! $this->table) {
            throw new \RuntimeException("Could not detected model ". $this->getClassName() . " table name.");
        }

        return $this->table;
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






    /**
     * @return string
    */
    private static function getPrimaryKey(): string
    {
         if (! self::$primaryKey) {
              throw new \RuntimeException("Could not find primary key in : ". self::getClassName());
         }

         return self::$primaryKey;

    }




    /**
     * Returns id
     *
     * @return int
    */
    protected function getId(): int
    {
         return $this->getAttribute($this->getPrimaryKey());
    }







    /**
     * @return array
    */
    protected abstract function mapAttributes(): array;
}