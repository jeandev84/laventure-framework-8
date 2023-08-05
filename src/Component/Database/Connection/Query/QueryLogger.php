<?php
namespace Laventure\Component\Database\Connection\Query;

class QueryLogger
{


     /**
      * @var array
     */
     protected $params = [];





    /**
     * @param array $params
     *
     * @return $this
    */
    public function log(array $params): static
    {
         $this->params[] = $params;

         return $this;
    }





    /**
     * @return array
    */
    public function getQueries(): array
    {
        return $this->params;
    }
}