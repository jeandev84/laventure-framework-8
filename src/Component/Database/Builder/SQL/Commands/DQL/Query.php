<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;

use Laventure\Component\Database\Connection\Query\QueryResultInterface;

class Query
{

        /**
         * @var QueryResultInterface
        */
        protected QueryResultInterface $hydrate;



        /**
         * @var string
        */
        protected string $classname;




        /**
         * @param Select $select
        */
        public function __construct(Select $select)
        {
              $this->hydrate = $select->fetch();
        }





        /**
         * @param string $classname
         *
         * @return $this
        */
        public function map(string $classname): static
        {
             $this->hydrate->map($classname);

             return $this;
        }
}