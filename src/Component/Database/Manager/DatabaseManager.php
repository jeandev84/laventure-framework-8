<?php
namespace Laventure\Component\Database\Manager;


use Laventure\Component\Database\Connection\Configuration\Configuration;
use Laventure\Component\Database\Connection\Configuration\ConfigurationInterface;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\ConnectionStack;



/**
 * @DatabaseManager
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Manager
*/
class DatabaseManager implements DatabaseManagerInterface
{

        /**
         * @var string|null
        */
        protected ?string $connection;




        /**
         * @var ConnectionInterface[]
        */
        protected array $connections = [];




        /**
         * @var array
        */
        protected array $credentials = [];





        /**
         * @var ConnectionInterface[]
        */
        protected array $connected = [];






        /**
         * @inheritdoc
        */
        public function open(string $name, array $config): void
        {
             $this->setConnections(ConnectionStack::defaults());
             $this->setCurrentConnection($name);
             $this->setCredentials($config);
        }






        /**
         * Set configuration from arrays
         *
         * @param array $config
         *
         * @return $this
        */
        public function setCredentials(array $config): static
        {
             foreach ($config as $name => $params) {
                 $this->credentials[$name] = $params;
             }

             return $this;
        }







        /**
         * @param string $name
         *
         * @return array
        */
        public function credentials(string $name): array
        {
             if (empty($this->credentials[$name])) {
                  $this->abortIf("empty credentials for connection '$name'");
             }

             return $this->credentials[$name];
        }





        /**
         * @param ConnectionInterface $connection
         *
         * @return $this
        */
        public function setConnection(ConnectionInterface $connection): static
        {
            $this->connections[$connection->getName()] = $connection;

            return $this;
        }







        /**
         * Determine if exists connection by given name
         *
         * @param string $name
         *
         * @return bool
        */
        public function hasConnection(string $name): bool
        {
            return isset($this->connections[$name]);
        }







        /**
         * @param array $connections
         *
         * @return $this
        */
        public function setConnections(array $connections): static
        {
             foreach ($connections as $connection) {
                 $this->setConnection($connection);
             }

             return $this;
        }







        /**
         * @param string|null $name
         *
         * @return ConnectionInterface
        */
        public function connection(string $name = null): ConnectionInterface
        {
             $name        = $name ?: $this->connection;
             $credentials = $this->credentials($name);

             if (! $this->hasConnection($name)) {
                 $this->abortIf("unavailable connection named '$name'");
             }

             return $this->connect($name, $credentials);
        }







        /**
         * @inheritdoc
        */
        public function connected(string $name): bool
        {
             return isset($this->connected[$name]);
        }







        /**
         * @inheritdoc
        */
        public function getConnections(): array
        {
            return $this->connections;
        }








        /**
         * @inheritdoc
        */
        public function close(): void
        {
             $this->connection  = null;
             $this->credentials = [];
             $this->connections = [];
             $this->connected   = [];
        }









        /**
         * @param string $name
         *
         * @param array $credentials
         *
         * @return ConnectionInterface
        */
        private function connect(string $name, array $credentials): ConnectionInterface
        {
              $this->connections[$name]->connect(new Configuration($credentials));

              if (! $this->connections[$name]->connected()) {
                 $this->abortIf("no connection detected for '$name'.");
              }

              $this->setCurrentConnection($name);

              return $this->connected[$name] = $this->connections[$name];
        }








        /**
         * @param string $connection
         *
         * @return void
        */
        private function setCurrentConnection(string $connection): void
        {
             $this->connection = $connection;
        }









        /**
         * @inheritDoc
        */
        public function config(): Configuration
        {
            return new Configuration($this->credentials);
        }





        /**
         * @return array
        */
        public function getCredentials(): array
        {
             return $this->credentials;
        }


        /**
         * @param string $message
         * @param int $code
         * @return void
        */
        public function abortIf(string $message, int $code = 500): void
        {
             (function () use ($message, $code) {
                throw new DatabaseManagerException($message, $code);
              })();
        }
}