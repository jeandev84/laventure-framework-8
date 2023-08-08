<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO;



use Closure;
use Exception;
use Laventure\Component\Database\Connection\Query\QueryInterface;
use PDO;
use PDOException;


/**
 * @PdoConnection
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection\Extensions\PDO
*/
class PdoConnection implements PdoConnectionInterface
{


    /**
     * @var PDO|null
    */
    protected ?PDO $pdo;




    /**
     * @var Query|null
    */
    protected ?Query $statement;




    /**
     * @var Query[]
    */
    protected array $queries = [];




    /**
     * @var array
    */
    protected array $options = [
        PDO::ATTR_PERSISTENT          => true,
        PDO::ATTR_EMULATE_PREPARES    => 0,
        PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION,
    ];





    /**
     * @param string $dsn
     *
     * @param string|null $username
     *
     * @param string|null $password
     *
     * @param array $options
    */
    public function open(string $dsn, string $username = null, string $password = null, array $options = [])
    {
         try {

             $this->pdo = new PDO($dsn, $username, $password, array_merge($this->options, $options));

         } catch (Exception $e) {

            throw new PDOException($e->getMessage(), $e->getCode());
         }
    }





    /**
     * @return bool
    */
    public function connected(): bool
    {
        return $this->pdo instanceof PDO;
    }






    /**
     * @return void
    */
    public function close(): void
    {
        $this->pdo = null;
    }





    /**
     * @return bool
    */
    public function disconnected(): bool
    {
        return is_null($this->pdo);
    }









    /**
     * @return QueryInterface
    */
    public function createQuery(): QueryInterface
    {
        return $this->addQuery(new Query($this->getPdo()));
    }






    /**
     * @param string $sql
     *
     * @param array $params
     *
     * @return QueryInterface
    */
    public function statement(string $sql, array $params = []): QueryInterface
    {
        return $this->createQuery()->prepare($sql)->setParameters($params);
    }







    /**
     * @return bool
    */
    public function beginTransaction(): bool
    {
        return $this->pdo?->beginTransaction();
    }





    /**
     * @return bool
    */
    public function hasActiveTransaction(): bool
    {
        return $this->pdo?->inTransaction();
    }





    /**
     * @return bool
    */
    public function commit(): bool
    {
        return $this->pdo?->commit();
    }






    /**
     * @return bool
    */
    public function rollback(): bool
    {
       return $this->pdo?->rollBack();
    }





    /**
     * @param Closure $closure
     *
     * @return bool
    */
    public function transaction(Closure $func): bool
    {
        $this->beginTransaction();

        try {

            $func($this);

            return $this->commit();

        } catch (PDOException $e) {

            if ($this->hasActiveTransaction()) {
                $this->rollBack();
            }

            $this->close();

            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }





    /**
     * @param $name
     *
     * @return int
    */
    public function lastInsertId($name = null): int
    {
        return $this->pdo?->lastInsertId($name);
    }






    /**
     * @param string $sql
     *
     * @return bool
    */
    public function exec(string $sql): bool
    {
        return $this->createQuery()->exec($sql);
    }






    /**
     * @inheritDoc
    */
    public function getPdo(): PDO
    {
        if (! $this->connected()) {
            trigger_error("No connection detected in: ". __CLASS__);
        }

        return $this->pdo;
    }






    /**
     * @return array
    */
    public function getDrivers(): array
    {
        return PDO::getAvailableDrivers();
    }






    /**
     * @param string $name
     *
     * @return bool
    */
    public function enabledDriver(string $name): bool
    {
        return in_array($name, $this->getDrivers());
    }






    /**
     * @return QueryInterface[]
    */
    public function getQueries(): array
    {
        return $this->queries;
    }





    /**
     * @param Query $query
     *
     * @return QueryInterface
    */
    private function addQuery(Query $query): QueryInterface
    {
        $this->queries[] = $query;

        return $query;
    }
}