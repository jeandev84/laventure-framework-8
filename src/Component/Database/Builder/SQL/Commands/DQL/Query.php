<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;

use Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract\SelectQueryInterface;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Persistence\ObjectPersistenceInterface;
use Laventure\Component\Database\Connection\Query\QueryResultInterface;




/**
 * @inheritdoc
*/
class Query implements SelectQueryInterface
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
         * @var string
        */
        protected string $mapped;





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
         * @inheritdoc
        */
        public function getResult(): array
        {
            $records = $this->hydrate->all();

            $this->persistence->persistence($records);

            return $records;
        }






        /**
         * @inheritdoc
        */
        public function getOneOrNullResult(): mixed
        {
            $record = $this->hydrate->one();

            $this->persistence->persistence([$record]);

            return $record;
        }






        /**
         * @inheritdoc
        */
        public function getArrayResult(): array
        {
            return $this->hydrate->assoc();
        }





        /**
         * @inheritDoc
        */
        public function getArrayColumns(): array
        {
            return $this->hydrate->columns();
        }






        /**
         * @inheritDoc
        */
        public function getMappedClass(): string
        {
            return $this->mapped;
        }
}