<?php
namespace Laventure\Component\Database\ORM\ActiveRecord;


use Laventure\Component\Database\Builder\Builder;
use Laventure\Component\Database\Manager;



/**
 * @inheritdoc
*/
abstract class Model implements ActiveRecordInterface
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
    protected string $primary = 'id';





    /**
     * @var string|null
    */
    protected ?string $connection = null;





    /**
     * @var array
    */
    protected array $attributes = [];





    /**
     * @var array
    */
    protected array $selects = [];





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
    protected static $instance;







    /**
     * @param string|null $selects
     *
     * @return $this
    */
    public static function select(string $selects = null): static
    {
         static::$instance = new static();

         static::$instance->selects[] = $selects;

         return static::$instance;
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
        static::$instance->orderBy[] = "$column $direction";

        return static::$instance;
    }






    /**
     * @param int $limit
     *
     * @return $this
    */
    public function limit(int $limit): static
    {
        static::$instance->limit = $limit;

        return static::$instance;
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
          static::$instance->wheres[$column] = compact('column', 'operator', 'value');

          return static::$instance;
    }





    /**
     * @param string $column
     *
     * @param array $value
     *
     * @return $this
    */
    public function whereIn(string $column, array $value): static
    {
         return static::where($column, $value, "IN :($column)");
    }








    /**
     * @return array
    */
    public function get(): array
    {
        if (! self::$instance) { return []; }

        $selects = join(', ', self::$instance->selects);
        $alias   =  mb_substr($this->getTable(), 0, 1, "UTF-8");

        $qb = $this->createQueryBuilder()
                   ->select($selects ?: null)
                   ->from($this->getTable(), $this->alias)
                   ->map(get_class($this));


        if ($wheres = self::$instance->wheres) {
            foreach ($wheres as  $items) {
                 [$column, $operator, $value] = array_values($items);
                 $qb->where("$column $operator");
                 $qb->setParameter($column, $value);
             }
        }


        dd(self::$instance);
    }






    /**
     * @return object|null
    */
    public function one(): ?object
    {

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

    }






    /**
     * @inheritDoc
    */
    public static function find(int $id): ?object
    {

    }




    /**
     * @inheritDoc
    */
    public static function findAll(): array
    {

    }





    /**
     * @return Manager
    */
    private function getManager(): Manager
    {
         if(! $database = Manager::instance()) {
              throw new \RuntimeException("No connection to database detected in : ". get_class($this));
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
     * @return string
    */
    protected function getTable(): string
    {
         return $this->table;
    }




    private function __construct() {}
}