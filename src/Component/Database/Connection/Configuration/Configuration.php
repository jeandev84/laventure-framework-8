<?php
namespace Laventure\Component\Database\Connection\Configuration;


/**
 * @inheritdoc
*/
class Configuration implements ConfigurationInterface
{


        /**
         * @var array
        */
        protected array $params = [];





        /**
         * @param array $params
        */
        public function __construct(array $params)
        {
             $this->merge($params);
        }





        /**
         * @param string $key
         *
         * @param $value
         *
         * @return $this
        */
        public function set(string $key, $value): static
        {
            $this->params[$key] = $value;

            return $this;
        }





        /**
         * @inheritDoc
        */
        public function merge(array $params): static
        {
             $this->params = array_merge($this->params, $params);

             return $this;
        }





        /**
         * @inheritDoc
        */
        public function get(string $name, $default = null): mixed
        {
            return $this->params[$name] ?? $default;
        }







         /**
          * @param string $name
          *
          * @return mixed
        */
        public function required(string $name): mixed
        {
             if ($this->empty($name)) {
                 trigger_error("Connection config param $name is required.");
             }

             return $this->get($name);
        }







        /**
         * @param string $name
         *
         * @return bool
        */
        public function empty(string $name): bool
        {
             return empty($this->params[$name]);
        }







        /**
         * @inheritDoc
        */
        public function has(string $name): bool
        {
            return isset($this->params[$name]);
        }





        /**
         * @inheritdoc
        */
        public function isEmpty(): bool
        {
            return empty($this->params);
        }







        /**
         * @inheritDoc
        */
        public function remove(string $name): bool
        {
            unset($this->params[$name]);

            return $this->has($name);
        }






        /**
         * @inheritDoc
        */
        public function getParams(): array
        {
            return $this->params;
        }





        /**
         * @inheritDoc
        */
        public function driver(): string
        {
            return $this->get('driver');
        }






        /**
         * @inheritDoc
        */
        public function username(): ?string
        {
            return $this->get('username');
        }







        /**
         * @inheritDoc
        */
        public function password(): ?string
        {
            return $this->get('password');
        }






        /**
         * @inheritDoc
        */
        public function charset(): string
        {
            return $this->get('charset', 'utf8');
        }






        /**
         * @inheritDoc
        */
        public function prefix(): string
        {
            return $this->get('prefix', '');
        }








        /**
         * @inheritDoc
        */
        public function engine(): string
        {
            return $this->get('engine', '');
        }







        /**
         * @inheritDoc
        */
        public function host(): string
        {
            return $this->get('host', '');
        }






        /**
         * @inheritDoc
        */
        public function port(): string
        {
            return $this->get('port', '');
        }





        /**
         * @inheritDoc
        */
        public function database(): string
        {
            return $this->get('database', '');
        }





        /**
         * @return string
        */
        public function collation(): string
        {
            return $this->get('collation', '');
        }






        /**
         * @return array
        */
        public function keys(): array
        {
             return array_keys($this->params);
        }








        /**
         * @return void
        */
        public function removeAll(): void
        {
             foreach ($this->keys() as $name) {
                 $this->remove($name);
             }
        }





        /**
         * @inheritDoc
        */
        public function offsetExists(mixed $offset): bool
        {
             return $this->has($offset);
        }






        /**
         * @inheritDoc
        */
        public function offsetGet(mixed $offset): mixed
        {
            return $this->get($offset);
        }





        /**
         * @inheritDoc
        */
        public function offsetSet(mixed $offset, mixed $value): void
        {
             $this->set($offset, $value);
        }






        /**
         * @inheritDoc
        */
        public function offsetUnset(mixed $offset): void
        {
            $this->remove($offset);
        }





        /**
         * @param string $message
         *
         * @return mixed
        */
        public function abortIf(string $message): mixed
        {
             return (function () use ($message) {
                 throw new ConfigurationException($message);
             })();
        }
}