<?php
namespace Laventure\Component\Database\Connection\Query;

class QueryLogger
{


     /**
      * @var QueryResultInterface
     */
     protected QueryResultInterface $queryResult;





     /**
      * @var array
     */
     protected array $executedQueries = [];





     public function __construct()
     {
         $this->queryResult = new NullQueryResult();
     }





     /**
     * @param array $params
     *
     * @return $this
    */
    public function logExecutedQuery(array $params): static
    {
         $this->executedQueries[] = $params;

         return $this;
    }






    /**
     * @param QueryResultInterface $queryResult
     *
     * @return QueryResultInterface
    */
    public function setQueryResult(QueryResultInterface $queryResult): QueryResultInterface
    {
        $this->queryResult = $queryResult;

        return $queryResult;
    }







    /**
     * @return QueryResultInterface
    */
    public function getQueryResult(): QueryResultInterface
    {
        return $this->queryResult;
    }







    /**
     * @return array
    */
    public function getExecutedQueries(): array
    {
        return $this->executedQueries;
    }
}