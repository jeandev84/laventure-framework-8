<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO;

use Exception;
use Laventure\Component\Database\Connection\Query\QueryException;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use Laventure\Component\Database\Connection\Query\QueryLogger;
use Laventure\Component\Database\Connection\Query\QueryResultInterface;
use PDO;
use PDOException;
use PDOStatement;


/**
 * @Query
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection\Extensions\PDO
*/
class Query implements QueryInterface
{

    /**
     * @var PDO
    */
    protected PDO $pdo;




    /**
     * @var PDOStatement
    */
    protected PDOStatement $statement;



    /**
     * @var QueryLogger
    */
    protected QueryLogger $logger;




    /**
     * @var array
    */
    protected array $bindings = [];



    /**
     * @var array
    */
    protected array $parameters = [];




    /**
     * @var array
    */
    protected array $bindParamTypes = [
        'integer' => \PDO::PARAM_INT,
        'boolean' => \PDO::PARAM_BOOL,
        'null'    => \PDO::PARAM_NULL
    ];




    /**
     * @param PDO $pdo
    */
    public function __construct(PDO $pdo)
    {
        $this->pdo       = $pdo;
        $this->statement = new PDOStatement();
        $this->logger    = new QueryLogger();
    }




    /**
     * @inheritDoc
    */
    public function prepare(string $sql): static
    {
        $this->statement = $this->pdo->prepare($sql);

        return $this;
    }





    /**
     * @inheritDoc
     */
    public function query(string $sql): static
    {
        $this->statement = $this->pdo->query($sql);

        return $this;
    }





    /**
     * @inheritDoc
     */
    public function bindParams(array $params): static
    {
        foreach ($params as $key => $value) {
            $this->bindParam($key, $value);
        }

        return $this;
    }




    /**
     * @param string $column
     *
     * @param $value
     *
     * @return $this
    */
    public function bindParam(string $column, $value): static
    {
           $type = strtolower(gettype($value));

           $code = $this->bindParamTypes[$type] ?? \PDO::PARAM_STR;

           $this->statement->bindParam(":$column", $value, $code);

           $this->bindings['params'][$column] = $value;

           return $this;
    }





    /**
     * @inheritdoc
    */
    public function bindColumns(array $columns): static
    {
        // todo refactoring

        foreach ($columns as $key => $value) {
            $this->statement->bindColumn($key, $value);
        }

        $this->bindings['columns'][] = $columns;

        return $this;
    }






    /**
     * @inheritDoc
    */
    public function bindValues(array $values): static
    {
        // todo refactoring
        foreach ($values as $key => $value) {
            $this->statement->bindValue($key, $value);
        }

        $this->bindings['values'][] = $values;

        return $this;
    }





    /**
     * @inheritDoc
    */
    public function setParameters(array $parameters): static
    {
        $this->parameters = $parameters;

        return $this;
    }





    /**
     * @inheritDoc
    */
    public function execute(): bool
    {
        try {

            if ($status = $this->statement->execute($this->parameters)) {

                $this->logger->log([
                    'sql'            => $this->statement->queryString,
                    'bindings'       => $this->bindings,
                    'parameters'     => $this->parameters
                ]);
            }

        } catch (PDOException $e) {
            $this->abort($e);
        }

        return $status;
    }





    /**
     * @inheritDoc
    */
    public function exec(string $sql): bool
    {
        try {

            $this->pdo->exec($sql);

            $this->logger->log(compact('sql'));

            return true;

        } catch (PDOException $e) {

            (function () use ($e) {
                throw new QueryException($e->getMessage(), $e->getCode());
            })();
        }
    }






    /**
     * @inheritDoc
    */
    public function fetch(): QueryResultInterface
    {
        $this->execute();

        return new QueryResult($this->statement);
    }





    /**
     * @inheritDoc
    */
    public function getQueryLog(): array
    {
        return $this->logger->getQueries();
    }





    /**
     * @param Exception $e
     *
     * @return mixed
    */
    public function abort(Exception $e): mixed
    {
        return (function () use ($e) {
            throw new QueryException($e->getMessage(), $e->getCode());
        })();
    }
}