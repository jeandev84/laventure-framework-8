<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO;

use Laventure\Component\Database\Connection\Query\QueryResultInterface;
use Laventure\Component\Database\Connection\Query\QueryResultLogger;
use PDO;
use PDOStatement;


/**
 * @inheritdoc
*/
class QueryResult implements QueryResultInterface
{


    /**
     * @var QueryResultLogger
    */
    protected QueryResultLogger $logger;




    /**
     * @var bool
    */
    protected bool $mapped = false;



    /**
     * @var object[]
    */
    protected array $mapping = [];




    /**
     * @param PDOStatement $statement
    */
    public function __construct(protected PDOStatement $statement)
    {
    }





    /**
     * @inheritDoc
    */
    public function map(string $classname): static
    {
        $this->statement->setFetchMode(PDO::FETCH_CLASS, $classname);

        $this->mapped = true;

        return $this;
    }






    /**
     * @inheritDoc
    */
    public function all(): array
    {
        $records = $this->statement->fetchAll();

        if ($this->mapped) {
            $this->mapping[] = $records;
        }

        return $records;
    }





    /**
     * @inheritDoc
    */
    public function one(): mixed
    {
        $record = $this->statement->fetch();

        if ($this->mapped) {
            $this->mapping[] = $record;
        }

        return $record;
    }





    /**
     * @inheritDoc
    */
    public function assoc(): array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }




    /**
     * @inheritDoc
    */
    public function column(int $column = 0): mixed
    {
         return $this->statement->fetchColumn($column);
    }





    /**
     * @inheritDoc
    */
    public function columns(): array|false
    {
        return $this->statement->fetchAll(PDO::FETCH_COLUMN);
    }






    /**
     * @inheritDoc
    */
    public function numRows(): int
    {
        return $this->statement->rowCount();
    }





    /**
     * @inheritDoc
    */
    public function getMapped(): array
    {
         return $this->mapping;
    }
}