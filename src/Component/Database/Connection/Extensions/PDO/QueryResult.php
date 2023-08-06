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
        return $this->statement->fetchAll();
    }





    /**
     * @inheritDoc
    */
    public function one(): mixed
    {
        return $this->statement->fetch();
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
}