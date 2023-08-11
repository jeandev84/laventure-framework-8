<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


use Laventure\Component\Database\Manager;
use Laventure\Component\Database\ORM\Convertor\CamelConvertor;


/**
 * @inheritdoc
*/
abstract class ActiveRecord implements ActiveRecordInterface,  \JsonSerializable
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
    protected string $primaryKey = 'id';





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
     * @var static
    */
    protected static $instance;




    /**
     * ActiveRecord constructor
    */
    private function __construct() {}









    /**
     * @return Query
    */
    protected function query(): Query
    {
        $manager = $this->getManager();
        $connection = $manager->pdoConnection($this->connection);
        return new Query($connection, $this->getTable(), $this->getClassName(), $this->getTableAlias());
    }






    /**
     * @param string|array $selects
     *
     * @return Query
    */
    public static function select(string|array $selects = ''): Query
    {
         return self::model()->query()->select($selects);
    }





    /**
     * @param string $column
     *
     * @param $value
     *
     * @param string $operator
     *
     * @return Query
    */
    public static function where(string $column, $value, string $operator): Query
    {
        return self::model()->query()->where($column, $value, $operator);
    }






    /**
     * @param string $column
     *
     * @param string $direction
     *
     * @return Query
    */
    public static function orderBy(string $column, string $direction = 'asc'): Query
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
        return self::model()->getById($id);
    }








    /**
     * @return array
    */
    public static function all(): array
    {
        return self::select()->get();
    }







    /**
     * @param int $page
     *
     * @param int $limit
     *
     * @return array
    */
    public static function paginate(int $page, int $limit): array
    {

    }






    /**
     * @param array $data
     *
     * @return Collection
    */
    public static function collection(array $data): Collection
    {
        return new Collection($data);
    }








    /**
     * @param array $attributes
     *
     * @return int
    */
    public static function create(array $attributes): int
    {
        return self::model()->query()->create($attributes);
    }






    /**
     * @param array $attributes
     *
     * @return mixed
    */
    public function update(array $attributes): mixed
    {
         return self::model()->query()
                             ->where($this->primaryKey(), $this->getId())
                             ->update($attributes);
    }





    /**
     * @return bool
    */
    public function delete(): bool
    {
        return self::model()->query()
                            ->where($this->primaryKey(), $this->getId())
                            ->delete();
    }








    /**
     * Save data
     *
     * @return int
    */
    public function save(): int
    {
        if (! $attributes = $this->mapAttributesToSave()) {
            throw new \RuntimeException("No attributes mapped for saving in : ". $this->getClassName());
        }

        if ($id = $this->getId()) {
            $this->update($attributes);
        } else {
            $id = static::create($attributes);
        }

        return $id;
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
     * @return static
     */
    private static function model(): static
    {
        if (! self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }




    /**
     * Returns class name
     *
     * @return string
     */
    private function getClassName(): string
    {
        return get_called_class();
    }






    /**
     * @return string
     */
    protected function primaryKey(): string
    {
        if (! $this->primaryKey) {
            throw new \RuntimeException("Could not find primary key in : ". $this->getClassName());
        }

        return $this->primaryKey;
    }








    /**
     * @return Manager
     */
    protected function getManager(): Manager
    {
        if(! $database = Manager::instance()) {
            throw new \RuntimeException("No connection to database detected in : ". $this->getClassName());
        }

        return $database;
    }





    /**
     * @return string
    */
    protected function getTable(): string
    {
        if (!$this->table) {
            throw new \RuntimeException("Could not detected model ". $this->getClassName() . " table name.");
        }

        return $this->table;
    }





    /**
     * @return string
    */
    protected function getTableAlias(): string
    {
        return $this->alias ?: mb_substr(static::getTable(), 0, 1, "UTF-8");
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
                   ->getColumns($this->getTable());
    }





    /**
     * Returns id
     *
     * @return int
    */
    private function getId(): int
    {
        return $this->getAttribute(self::primaryKey(), 0);
    }




    /**
     * @param int $id
     *
     * @return mixed
    */
    private function getById(int $id): mixed
    {
        return self::select()->where($this->primaryKey(), $id)->one();
    }





    /**
     * @inheritDoc
    */
    public function jsonSerialize(): mixed
    {
        return $this->getAttributes();
    }






    /**
     * Map attributes to save
     *
     * @return array
    */
    abstract protected function mapAttributesToSave(): array;
}