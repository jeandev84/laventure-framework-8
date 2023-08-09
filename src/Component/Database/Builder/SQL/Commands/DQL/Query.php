<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;


use Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence\ObjectPersistenceInterface;
use Laventure\Component\Database\Connection\Query\QueryResultInterface;




class Query
{

        /**
         * @var QueryResultInterface
        */
        protected QueryResultInterface $fetch;




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
              $this->fetch     = $hydrate;
              $this->persistence = $persistence;
        }






        /**
         * @return array
        */
        public function getResult(): array
        {
            $records = $this->fetch->all();

            $this->persistence->persistence($records);

            return $records;
        }






        /**
         * @return mixed
        */
        public function getOneOrNullResult(): mixed
        {
            $record = $this->fetch->one();

            $this->persistence->persistence([$record]);

            return $record;
        }





        /**
         * @return array
        */
        public function getArrayResult(): array
        {
            return $this->fetch->assoc();
        }






        /**
         * @return array
        */
        public function getArrayColumns(): array
        {
            return $this->fetch->columns();
        }
}