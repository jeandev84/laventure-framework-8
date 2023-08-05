<?php
namespace Laventure\Component\Database\Connection\Configuration;


/**
 * @ConfigurationInterface
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection\Definition
*/
interface ConfigurationInterface extends \ArrayAccess
{


        /**
         * Returns driver name
         *
         * @return string
        */
        public function driver(): string;






        /**
         * Returns host name
         *
         * @return string
        */
        public function host(): string;






        /**
         * Returns connection user
         *
         * @return string|null
        */
        public function username(): ?string;






        /**
         * Returns connection password
         *
         * @return string|null
        */
        public function password(): ?string;






        /**
         * Returns port
         *
         * @return string
        */
        public function port(): string;







        /**
         * Returns name of database
         *
         * @return string
        */
        public function database(): string;







        /**
         * Returns database encoding characters
         *
         * @return string
        */
        public function charset(): string;







        /**
         * Returns collation
         *
         * @return string
        */
        public function collation(): string;






        /**
         * Returns table prefix
         *
         * @return string
        */
        public function prefix(): string;








        /**
         * Returns engine name
         *
         * @return string
        */
        public function engine(): string;






        /**
         * @param array $params
         *
         * @return $this
        */
        public function merge(array $params): static;







        /**
         * Returns value of given name
         *
         * @param string $name
         *
         * @param $default
         *
         * @return mixed
        */
        public function get(string $name, $default = null): mixed;






        /**
         * Determine if the given param exist
         *
         * @param string $name
         *
         * @return bool
        */
        public function has(string $name): bool;






        /**
         * Determine if params empty
         *
         * @return bool
        */
        public function isEmpty(): bool;






        /**
         * Returns all configuration params
         *
         * @return array
        */
        public function getParams(): array;






        /**
         * Remove param
         *
         * @param string $name
         *
         * @return bool
        */
        public function remove(string $name): bool;
}