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
        protected array $config = [];





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
             $this->setDefaultConnection($name);
             $this->setConfigurations($config);
        }








        /**
         * @param string $name
         *
         * @param array $config
         *
         * @return $this
        */
        public function setConfiguration(string $name, array $config): static
        {
              $this->config[$name] = $config;

              return $this;
        }






        /**
         * Set configuration from arrays
         *
         * @param array $config
         *
         * @return $this
        */
        public function setConfigurations(array $config): static
        {
             foreach ($config as $name => $params) {
                 $this->setConfiguration($name, $params);
             }

             return $this;
        }







        /**
         * @param string $name
         *
         * @return ConfigurationInterface
        */
        public function configuration(string $name): ConfigurationInterface
        {
             if (! isset($this->config[$name])) {
                  $this->abortIf("unavailable configuration '$name'.");
             }

             $config = new Configuration($this->config[$name]);

             if ($config->isEmpty()) {
                  $this->abortIf("empty params for configuration '$name'");
             }

             return $config;
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
         * @param string $name
         *
         * @return ConnectionInterface
        */
        public function connection(string $name = ''): ConnectionInterface
        {
             $name   = $this->getDefaultConnection($name);
             $config = $this->configuration($name);

             if (! $this->hasConnection($name)) {
                 $this->abortIf("unavailable connection named '$name'");
             }

             return $this->connect($name, $config);
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
        public function getConfigurations(): array
        {
             return $this->config;
        }










        /**
         * @inheritdoc
        */
        public function close(): void
        {
             $this->connection  = null;
             $this->connections = [];
             $this->config      = [];
             $this->connected   = [];
        }









        /**
         * @param string $name
         *
         * @param ConfigurationInterface $config
         *
         * @return ConnectionInterface
        */
        private function connect(string $name, ConfigurationInterface $config): ConnectionInterface
        {
              $this->connections[$name]->connect($config);

              if (! $this->connections[$name]->connected()) {
                 $this->abortIf("no connection detected for '$name'.");
              }

              $this->setDefaultConnection($name);

              return $this->connected[$name] = $this->connections[$name];
        }








        /**
         * @param string $connection
         *
         * @return void
        */
        private function setDefaultConnection(string $connection): void
        {
             $this->connection = $connection;
        }







        /**
         * Returns current connection
         *
         * @param string $name
         *
         * @return string|null
        */
        private function getDefaultConnection(string $name = ''): ?string
        {
              return $name ?: $this->connection;
        }









       /**
        * @param string $message
        *
        * @return void
       */
       private function abortIf(string $message): void
       {
           (function () use ($message) {
              throw new DatabaseManagerException($message);
           })();
       }
}