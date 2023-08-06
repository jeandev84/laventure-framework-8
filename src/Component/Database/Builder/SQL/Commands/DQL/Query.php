<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;

use Laventure\Component\Database\Builder\SQL\Commands\DQL\Mapping\ObjectPersistenceInterface;
use Laventure\Component\Database\Connection\Query\QueryResultInterface;

class Query
{

        /**
         * @var QueryResultInterface
        */
        protected QueryResultInterface $hydrate;




        /**
         * @var ObjectPersistenceInterface
        */
        protected ObjectPersistenceInterface $persistence;





        /**
         * @param QueryResultInterface $hydrate
         *
         * @param ObjectPersistenceInterface $persistence
        */
        public function __construct(QueryResultInterface $hydrate, ObjectPersistenceInterface $persistence)
        {
              $this->hydrate     = $hydrate;
              $this->persistence = $persistence;
        }






        /**
         * @return array
        */
        public function getResult(): array
        {
            $records = $this->hydrate->all();

            $this->persistence->persistence($records);

            return $records;
        }






        /**
         * @return object|mixed|null
        */
        public function getOneOrNullResult(): mixed
        {
            $record = $this->hydrate->one();

            $this->persistence->persistence([$record]);

            return $record;
        }






        /**
         * @return array
        */
        public function getArrayResult(): array
        {
            return $this->hydrate->assoc();
        }
}