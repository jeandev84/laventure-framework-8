<?php
namespace Laventure\Component\Database\Connection\Query;


/**
 * @SelectQueryInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection\QueryBuilder
*/
interface QueryInterface
{

        /**
         * Prepare sql statement
         *
         * @param string $sql
         *
         * @return $this
        */
        public function prepare(string $sql): static;





        /**
         * Bind query params
         *
         * @param array $params
         *
         * @return $this
        */
        public function bindParams(array $params): static;







        /**
         * Bind query values
         *
         * @param array $values
         *
         * @return $this
        */
        public function bindValues(array $values): static;





        /**
         * Bind query columns
         *
         * @param array $columns
         * @return $this
        */
        public function bindColumns(array $columns): static;





        /**
         * Set params to execute
         *
         * @param array $parameters
         *
         * @return $this
        */
        public function setParameters(array $parameters): static;







        /**
         * Execute query
         *
         * Returns last insert id or boolean
         *
         * @return int|bool
        */
        public function execute(): int|bool;







        /**
         * Execute query
         *
         * @param string $sql
         *
         * @return mixed
        */
        public function exec(string $sql): mixed;









        /**
         * Fetch Result
         *
         * @return QueryResultInterface
        */
        public function fetch(): QueryResultInterface;









        /**
         * Returns last inserted ID
         *
         * @return int
        */
        public function lastId(): int;








        /**
         * Returns executed queries
         *
         * @return QueryLogger
        */
        public function getLogger(): QueryLogger;
}