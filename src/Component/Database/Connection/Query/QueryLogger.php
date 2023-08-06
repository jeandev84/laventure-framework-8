<?php
namespace Laventure\Component\Database\Connection\Query;

class QueryLogger
{

     /**
      * @var array
     */
     protected array $log = [];





     /**
     * @param array $params
     *
     * @return $this
    */
    public function log(array $params): static
    {
         $this->log[] = $params;

         return $this;
    }





    /**
     * @return array
    */
    public function getQueriesInfo(): array
    {
        return $this->log;
    }
}