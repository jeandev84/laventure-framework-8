<?php
namespace Laventure\Component\Database\Connection\Extensions\PDO;


use Laventure\Component\Database\Connection\Configuration\ConfigurationInterface;
use Laventure\Component\Database\Connection\ConnectionInterface;
use Laventure\Component\Database\Connection\Exception\DriverConnectionException;
use PDO;


/**
 * @DriverConnection
 *
 * @author Jean-Claude <jeanyao@ymail.com>
 *
 * @license https://github.com/jeandev84/laventure-framework/blob/master/LICENSE
 *
 * @package Laventure\Component\Database\Connection\Extensions\PDO
*/
abstract class DriverConnection extends PdoConnection implements ConnectionInterface
{

    /**
     * @var ConfigurationInterface|null
    */
    protected ?ConfigurationInterface $config;



    /**
     * @inheritDoc
    */
    public function connect(ConfigurationInterface $config): void
    {
         $this->setConnection($config);
    }






    /**
     * @param ConfigurationInterface $config
     *
     * @return void
    */
    public function setConnection(ConfigurationInterface $config): void
    {
          if (! $this->enabledDriver($driver = $config->driver())) {
              $this->createDriverException("Unavailable PDO driver '$driver'");
          }

          $this->config = $this->resolveConfiguration($config);

          $this->connectionBefore($this->config);

          if (in_array($this->config['database'], $this->getDatabases())) {
              $this->connectionAfter($this->config);
          }
    }






    /**
     * @inheritDoc
    */
    public function getConnection(): ?PDO
    {
        return $this->pdo;
    }






    /**
     * @inheritDoc
    */
    public function config(): ConfigurationInterface
    {
        return $this->config;
    }







    /**
     * @inheritDoc
    */
    public function hasDatabase(): bool
    {
       return in_array($this->config->database(), $this->getDatabases());
    }





    /**
     * @inheritDoc
    */
    public function reconnect(): void
    {
         $this->connect($this->config);
    }





    /**
     * @param ConfigurationInterface $config
     *
     * @return void
    */
    private function connectionBefore(ConfigurationInterface $config): void
    {
        $this->open($config['dsn'], $config->username(), $config->password(), $config->get('options', []));
    }





    /**
     * @param ConfigurationInterface $config
     *
     * @return void
     */
    private function connectionAfter(ConfigurationInterface $config): void
    {
        $config['dsn'] .= ";dbname={$config->database()};";

        $this->open($config['dsn'], $config->username(), $config->password(), $config->get('options', []));
    }





    /**
     * @ri
    */
    public function disconnect(): void
    {
         $this->close();
    }



    /**
     * @inheritDoc
    */
    public function getDatabase(): string
    {
        return $this->config->database();
    }







    /**
     * @inheritdoc
    */
    public function purge(): bool
    {
         $this->disconnect();
         $this->config = null;
         return true;
    }









    /**
     * @param string $driver
     *
     * @param array $params
     *
     * @return string
    */
    protected function buildPdoDsn(string $driver, array $params): string
    {
         return sprintf('%s:%s',  $driver, http_build_query($params,'', ';'));
    }





    /**
     * @param string $message
     *
     * @return mixed
    */
    private function createDriverException(string $message): void
    {
         (function () use ($message) {
              throw new DriverConnectionException($message);
         })();
    }





    /**
     * @inheritDoc
    */
    public function hasTable(string $name): bool
    {
        return in_array($name, $this->getTables());
    }





    /**
     * @param ConfigurationInterface $config
     *
     * @return ConfigurationInterface
    */
    abstract protected function resolveConfiguration(ConfigurationInterface $config): ConfigurationInterface;
}