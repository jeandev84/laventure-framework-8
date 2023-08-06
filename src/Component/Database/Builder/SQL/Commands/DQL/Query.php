<?php
namespace Laventure\Component\Database\Builder\SQL\Commands\DQL;

use Laventure\Component\Database\Builder\SQL\Commands\DQL\Contract\SelectQueryInterface;
use Laventure\Component\Database\Builder\SQL\Commands\DQL\Mapping\ObjectPersistenceInterface;
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
              $this->mapped      = $persistence->getMapped();
              $this->hydrate     = $this->mapped ? $hydrate->map($this->mapped) : $hydrate;
              $this->persistence = $persistence;
        }





        /**
         * @inheritdoc
        */
        public function hasMapping(): bool
        {
            return ! empty($this->mapped);
        }






        /**
         * @inheritdoc
        */
        public function getResult(): array
        {
            $records = $this->hydrate->all();

            if ($this->hasMapping()) {
                $this->persistence->persistence($records);
            }

            return $records;
        }






        /**
         * @inheritdoc
        */
        public function getOneOrNullResult(): mixed
        {
            $record = $this->hydrate->one();

            if ($this->hasMapping()) {
                $this->persistence->persistence([$record]);
            }

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